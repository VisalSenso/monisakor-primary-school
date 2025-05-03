import { useState } from "react";
import axios from "axios";

const Join = () => {
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

  const handleChange = (e) => {
    const { name, value } = e.target;
    if (name === "phone") {
      const numericValue = value.replace(/\D/g, "");
      if (numericValue.length <= 15) {
        setData({ ...data, [name]: numericValue });
      }
    } else {
      setData({ ...data, [name]: value });
    }
  };

  const handleFileChange = (e) => {
    setData({ ...data, image: e.target.files[0] });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);

    const trimmedData = { ...data };
    Object.entries(trimmedData).forEach(([key, value]) => {
      if (typeof value === "string") {
        trimmedData[key] = value.trim();
      }
    });

    let errors = {};
    Object.entries(trimmedData).forEach(([key, value]) => {
      if (!value && key !== "image") {
        errors[key] = "សូមបំពេញព័ត៌មាននេះ";
      }
    });

    const phonePattern = /^0\d{7,9}$/;
    if (!phonePattern.test(trimmedData.phone)) {
      errors.phone = "សូមបញ្ចូលលេខទូរស័ព្ទត្រឹមត្រូវ (ចាប់ផ្តើមដោយលេខ 0 មានចន្លោះ 8-10 ខ្ទង់)";
    }

    if (!trimmedData.image) {
      errors.image = "សូមអាប់ឡូដរូបភាពមកផង";
    } else {
      if (trimmedData.image.size > 2 * 1024 * 1024) {
        errors.image = "រូបភាពមិនអាចធំជាង 2MB";
      }
      if (!["image/jpeg", "image/png"].includes(trimmedData.image.type)) {
        errors.image = "សូមជ្រើសរូបភាពប្រភេទ JPG ឬ PNG ប៉ុណ្ណោះ";
      }
    }

    setFormErrors(errors);
    if (Object.keys(errors).length > 0) {
      setLoading(false);
      return;
    }

    const formDataToSend = new FormData();
    Object.entries(trimmedData).forEach(([key, value]) => {
      if (value !== null && value !== "") {
        formDataToSend.append(key, value);
      }
    });

    try {
      const response = await axios.post(
        "http://localhost/project/monisakor-primary-school/server/api/Join.php",
        formDataToSend,
        {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        }
      );

      const result = response.data;

      if (response.status === 200 && result.message) {
        alert("✅ " + result.message);
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
      } else {
        alert("❌ " + result.error);
      }
    } catch (error) {
      console.error("Error:", error);
      if (error.response?.data?.error) {
        alert("❌ " + error.response.data.error);
      } else {
        alert("❌ មានបញ្ហាមួយចំនួន។ សូមព្យាយាមម្តងទៀត!");
      }
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
    place_of_birth: "បញ្ចូលទីកន្លែងកំណើត",
    current_place: "បញ្ចូលទីកន្លែងបច្ចុប្បន្ន",
    phone: "បញ្ចូលលេខទូរស័ព្ទ",
    image: "",
  };

  return (
    <form onSubmit={handleSubmit} className="space-y-4">
      {Object.entries(data).map(([key, value]) => (
        <div key={key} className="relative">
          <label
            htmlFor={key}
            className="text-sm font-medium text-gray-800 dark:text-gray-200"
          >
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
              phone: "លេខទូរស័ព្ទ",
              image: "រូបភាព",
            }[key]}
          </label>

          {key === "gender" ? (
            <select
              name={key}
              id={key}
              value={value}
              onChange={handleChange}
              className="w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none"
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
              className="w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none"
            />
          ) : key === "image" ? (
            <input
              type="file"
              name={key}
              id={key}
              accept="image/*"
              onChange={handleFileChange}
              className="w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none"
            />
          ) : (
            <input
              type={key === "phone" ? "tel" : "text"}
              name={key}
              id={key}
              value={value}
              placeholder={placeholderMap[key]}
              onChange={handleChange}
              className="w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none"
            />
          )}

          {formErrors[key] && (
            <p className="text-red-500 text-xs mt-1">{formErrors[key]}</p>
          )}
        </div>
      ))}

      <button
        type="submit"
        className="w-full py-2 px-4 bg-primary text-white font-medium rounded-lg hover:bg-opacity-90 transition"
        disabled={loading}
      >
        {loading ? "កំពុងដំណើរការ..." : "ចូលរួម"}
      </button>
    </form>
  );
};

export default Join;
