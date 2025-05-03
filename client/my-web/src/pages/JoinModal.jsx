import React, { useState } from "react";
import axios from "axios";
import { FaCheckCircle, FaTimes } from "react-icons/fa";
const JoinModal = ({ isOpen, onClose }) => {
    const [data, setData] = useState({
        full_name: "",
        gender: "",
        dob: "",
        father_name: "",
        father_job: "",
        mother_name: "",
        mother_job: "",
        place_of_birth: "",
        current_place: "",
        phone: "",
        image: null,
    });

    const [formErrors, setFormErrors] = useState({});
    const [loading, setLoading] = useState(false);

    const khmerNamePattern = /^[\u1780-\u17FF]{2,}\s[\u1780-\u17FF]{2,}$/;
    const placePattern = /^.+, .+, .+, .+$/;
    const phonePattern = /^0\d{7,9}$/;

    const cleanText = (text) =>
        text.normalize("NFC").replace(/[\u200B-\u200D\uFEFF]/g, "").trim();
    const [thankYouMessage, setThankYouMessage] = useState(false);


    
    const validateField = (name, value) => {
        let error = "";

        if (name !== "image" && !value) {
            error = "សូមបញ្ចប់ព័ត៌មាននេះ";
        }

        // For full_name, father_name, and mother_name
        if (["full_name", "father_name", "mother_name"].includes(name)) {
            if (value && !khmerNamePattern.test(value)) {
                error = "សូមបញ្ចូលឈ្មោះជាភាសាខ្មែរ (ឧ. គុណ កនិ្នកា)";
            }
        }


        if (["place_of_birth", "current_place"].includes(name)) {
            if (value && !placePattern.test(value)) {
                error = "សូមបញ្ចូលទ្រង់ទ្រាយត្រឹមត្រូវ៖ ភូមិ, ឃុំឬ សង្កាត់, ស្រុកឬ ខណ្ឌ, រាជធានីឬ ខេត្ដ";
            }
        }

        if (name === "phone" && value && !phonePattern.test(value)) {
            error = "សូមបញ្ចូលលេខទូរស័ព្ទត្រឹមត្រូវ (ចាប់ផ្តើមដោយលេខ 0 មានចន្លោះ 8-10 ខ្ទង់)";
        }

        return error;
    };


    const handleChange = (e) => {
        const { name, value } = e.target;
        const newValue = name === "phone" ? value.replace(/\D/g, "").slice(0, 15) : value;

        const cleanedValue = typeof newValue === "string" ? cleanText(newValue) : newValue;

        setData((prev) => ({ ...prev, [name]: newValue }));

        const error = validateField(name, cleanedValue);
        setFormErrors((prev) => ({ ...prev, [name]: error }));
    };

    const handleFileChange = (e) => {
        const file = e.target.files[0];
        setData((prev) => ({ ...prev, image: file }));

        let error = "";
        if (!file) {
            error = "សូមអាប់ឡូដរូបភាពមកផង";
        } else if (file.size > 2 * 1024 * 1024) {
            error = "រូបភាពមិនអាចធំជាង 2MB";
        } else if (!["image/jpeg", "image/png"].includes(file.type)) {
            error = "សូមជ្រើសរូបភាពប្រភេទ JPG ឬ PNG ប៉ុណ្ណោះ";
        }

        setFormErrors((prev) => ({ ...prev, image: error }));
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setLoading(true);

        let errors = {};
        Object.entries(data).forEach(([key, value]) => {
            if (key !== "image") {
                const cleaned = typeof value === "string" ? cleanText(value) : value;
                const error = validateField(key, cleaned);
                if (error) errors[key] = error;
            }
        });

        const file = data.image;
        if (!file) {
            errors.image = "សូមអាប់ឡូដរូបភាពមកផង";
        } else if (file.size > 2 * 1024 * 1024) {
            errors.image = "រូបភាពមិនអាចធំជាង 2MB";
        } else if (!["image/jpeg", "image/png"].includes(file.type)) {
            errors.image = "សូមជ្រើសរូបភាពប្រភេទ JPG ឬ PNG ប៉ុណ្ណោះ";
        }

        setFormErrors(errors);

        if (Object.keys(errors).length > 0) {
            setLoading(false);
            return;
        }

        const formDataToSend = new FormData();
        Object.entries(data).forEach(([key, value]) => {
            if (value) formDataToSend.append(key, value);
        });

        try {
            const response = await axios.post(
                "http://localhost/project/monisakor-primary-school/server/api/Join.php",
                formDataToSend,
                { headers: { "Content-Type": "multipart/form-data" } }
            );

            const result = response.data;

            if (response.status === 200 && result.message) {
                // alert("✅ " + result.message);
                setThankYouMessage(true);
                setData({
                    full_name: "",
                    gender: "",
                    dob: "",
                    father_name: "",
                    father_job: "",
                    mother_name: "",
                    mother_job: "",
                    place_of_birth: "",
                    current_place: "",
                    phone: "",
                    image: null,
                });
                setFormErrors({});
            } else {
                alert("❌ " + result.error);
            }
        } catch (error) {
            console.error("Error:", error);
            alert("❌ មានបញ្ហាមួយចំនួន។ សូមព្យាយាមម្តងទៀត!");
        }

        setLoading(false);
    };

    const placeholderMap = {
        full_name: "បញ្ចូលឈ្មោះពេញ",
        gender: "ជ្រើសរើសភេទ",
        dob: "ជ្រើសរើសថ្ងៃខែឆ្នាំកំណើត",
        father_name: "បញ្ចូលឈ្មោះឪពុក",
        father_job: "បញ្ចូលមុខរបររបស់ឪពុក",
        mother_name: "បញ្ចូលឈ្មោះម្តាយ",
        mother_job: "បញ្ចូលមុខរបររបស់ម្តាយ",
        place_of_birth: "បញ្ចូលទីកន្លែងកំណើត ឧ. ភូមិ ពោធិ៍ថ្មី, ឃុំ ស្វាយតាយាន, ស្រុក កំពុងរោទ៍, ខេត្ត ស្វាយរៀង",
        current_place: "បញ្ចូលទីកន្លែងបច្ចុប្បន្ន ឧ. ភូមិ ពោធិ៍ថ្មី, ឃុំ ស្វាយតាយាន, ស្រុក កំពុងរោទ៍, ខេត្ត ស្វាយរៀង",
        phone: "បញ្ចូលលេខទូរស័ព្ទ",
        image: "",
    };

    if (!isOpen) return null;

    return (
        <div className="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-[9999] p-4">
            <div className="bg-white dark:bg-gray-800 rounded-lg w-full max-w-2xl p-6 relative overflow-y-auto max-h-[90vh]">
                <button
                    onClick={onClose}
                    className="absolute top-2 right-4 text-3xl text-black dark:text-white hover:text-red-400 transition-colors duration-300 cursor-pointer"
                >
                    &times;
                </button>

                <div className="text-center mb-4">
                    <h2 className="text-xl font-bold ">ចុះឈ្នោះចូលរៀន</h2>
                    <p className="mt-2">សូមបញ្ចូលព័ត៌មានរបស់អ្នកជាភារសារខ្មែរដើម្បីចុះបញ្ជីនៅសាលារបស់យើង។</p>
                </div>

                <form onSubmit={handleSubmit} className="space-y-4">
                    {Object.entries(data).map(([key, value]) => (
                        <div key={key} className="relative">
                            <label htmlFor={key} className="text-sm font-medium text-gray-800 dark:text-gray-200">
                                {{
                                    full_name: "ឈ្មោះពេញ",
                                    gender: "ភេទ",
                                    dob: "ថ្ងៃខែឆ្នាំកំណើត",
                                    father_name: "ឈ្មោះឪពុក",
                                    father_job: "មុខរបររបស់ឪពុក",
                                    mother_name: "ឈ្មោះម្តាយ",
                                    mother_job: "មុខរបររបស់ម្តាយ",
                                    place_of_birth: "ទីកន្លែងកំណើត",
                                    current_place: "ទីកន្លែងបច្ចុប្បន្ន",
                                    phone: "លេខទូរស័ព្ទអាណាព្យាបាល",
                                    image: "រូបភាព",
                                }[key]}
                            </label>

                            {key === "gender" ? (
                                <select
                                    name={key}
                                    id={key}
                                    value={value}
                                    onChange={handleChange}
                                    className={`w-full px-4 py-2 mt-1 border ${formErrors[key] ? "border-red-500" : "border-gray-300"
                                        } rounded-lg focus:ring-2 focus:ring-primary focus:outline-none`}
                                >
                                    <option value="">{placeholderMap[key]}</option>
                                    <option value="ប្រុស">ប្រុស</option>
                                    <option value="ស្រី">ស្រី</option>
                                </select>
                            ) : key === "dob" ? (
                                <input
                                    type="date"
                                    name={key}
                                    id={key}
                                    value={value}
                                    onChange={handleChange}
                                    className={`w-full px-4 py-2 mt-1 border ${formErrors[key] ? "border-red-500" : "border-gray-300"
                                        } rounded-lg focus:ring-2 focus:ring-primary focus:outline-none`}
                                />
                            ) : key === "image" ? (
                                <input
                                    type="file"
                                    name={key}
                                    id={key}
                                    accept="image/*"
                                    onChange={handleFileChange}
                                    className={`w-full px-4 py-2 mt-1 border ${formErrors[key] ? "border-red-500" : "border-gray-300"
                                        } rounded-lg focus:ring-2 focus:ring-primary focus:outline-none`}
                                />
                            ) : (
                                <input
                                    type={key === "phone" ? "tel" : "text"}
                                    name={key}
                                    id={key}
                                    value={value}
                                    placeholder={placeholderMap[key]}
                                    onChange={handleChange}
                                    className={`w-full px-4 py-2 mt-1 border ${formErrors[key] ? "border-red-500" : "border-gray-300"
                                        } rounded-lg focus:ring-2 focus:ring-primary focus:outline-none`}
                                />
                            )}

                            {formErrors[key] && (
                                <p className="text-red-500 text-xs mt-1">{formErrors[key]}</p>
                            )}
                        </div>
                    ))}

                    <button
                        type="submit"
                        disabled={loading}
                        className={`w-full py-2 px-4 rounded-lg text-white font-semibold 
                            ${loading ? "bg-gray-400 cursor-not-allowed" : "bg-blue-600 hover:bg-blue-700"}
                            transition-colors duration-300`}
                    >
                        {loading ? "កំពុងដំណើរការ..." : "ដាក់ស្នើ"}
                    </button>
                </form>
                {thankYouMessage && (
                    <div className="fixed z-50 inset-0 overflow-y-auto">
                        <div className="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div
                                className="fixed inset-0 transition-opacity"
                                aria-hidden="true"
                            >
                                <div className="absolute inset-0 bg-black opacity-75"></div>
                            </div>

                            <span
                                className="hidden sm:inline-block sm:align-middle sm:h-screen"
                                aria-hidden="true"
                            >
                                &#8203;
                            </span>

                            <div
                                className="inline-block align-bottom bg-background-light dark:bg-background-dark rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6"
                                role="dialog"
                                aria-modal="true"
                                aria-labelledby="modal-headline"
                            >
                                <div class="hidden sm:block absolute top-0 right-0 pt-4 pr-4">
                                    <button
                                        type="button"
                                        onClick={() => setThankYouMessage(false)}
                                        className="bg-background-light dark:bg-background-dark rounded-md text-gray-800 dark:text-gray-200 hover:text-red-400 cursor-pointer focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                    >
                                        <span className="sr-only">Close</span>
                                        <FaTimes />
                                    </button>
                                </div>
                                <div className="sm:flex sm:items-start">
                                    <div className="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10 text-secondary">
                                        <FaCheckCircle />
                                    </div>
                                    <div className="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                        <h3
                                            class="text-lg leading-6 font-medium text-secondary"
                                            id="modal-headline"
                                        >
                                            សូមអរគុណចំពោះការចុះឈ្មោះរបស់អ្នក!
                                        </h3>
                                        <div className="mt-2">
                                            <p className="text-sm text-gray-800 dark:text-gray-200">

                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                )}
            </div>
        </div>
    );
};

export default JoinModal;
