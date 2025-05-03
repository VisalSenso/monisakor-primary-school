import React, { useState, useEffect, useRef } from "react";
import { useTranslation } from "react-i18next";
import axios from "axios";
import { FaCheckCircle, FaTimes, FaTelegram } from "react-icons/fa";
import img9 from "../assets/images/schoolImages/9.jpg";
import { Link, useLocation } from "react-router-dom";
import BackgroundIcons from "../components/BackgroundIcons";

const ContactUs = () => {
  const { t } = useTranslation();
  const [webContent, setWebContent] = useState({});
  const phonePattern = /^0\d{7,9}$/;
  const [formData, setFormData] = useState({
    name: "",
    phone: "",
    message: "",
  });
  const [formErrors, setFormErrors] = useState({});
  const [thankYouMessage, setThankYouMessage] = useState(false);
  const { i18n } = useTranslation(); // Get language info from i18next
  useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await axios.get(
          `http://localhost:/project/monisakor-primary-school/server/api/Contact.php?lang=${i18n.language}`
        );
        setWebContent(response.data.web_content || {});
      } catch (error) {
        console.error("Error fetching data:", error);
      }
    };

    fetchData();
  }, [i18n.language]);
  
  useEffect(() => {
    if (thankYouMessage) {
      const timer = setTimeout(() => setThankYouMessage(false), 4000);
      return () => clearTimeout(timer);
    }
  }, [thankYouMessage]);

  const validateField = (name, value) => {
    let error = "";

    if (name === "phone" && value && !phonePattern.test(value)) {
      error = t("phone_invalid");
    }

    return error;
  };

  const handleChange = (e) => {
    const { name, value } = e.target;
    const newValue = name === "phone" ? value.replace(/\D/g, "").slice(0, 15) : value;
    const error = validateField(name, newValue);

    setFormData((prevData) => ({ ...prevData, [name]: newValue }));
    setFormErrors((prevErrors) => ({ ...prevErrors, [name]: error }));
  };


  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      const response = await axios.post(
        "http://localhost:/project/monisakor-primary-school/server/api/Contact.php",
        new URLSearchParams(formData),
        { headers: { "Content-Type": "application/x-www-form-urlencoded" } }
      );


      if (response.data.error) {
        setFormErrors({ phone: t("phone_invalid") });
      } else {
        setThankYouMessage(true);
        setFormData({ name: "", phone: "", message: "" });
      }
    } catch (error) {
      console.error("Error submitting form:", error);
      setFormErrors({ general: "Something went wrong. Please try again later." });
    }



  };

  // scroll to contact section when the page is loaded with #contact hash
  const contactRef = useRef(null);
  const location = useLocation();
  useEffect(() => {
    if (location.hash === "#contact" && contactRef.current) {
      contactRef.current.scrollIntoView({ behavior: "smooth" });
    }
  }, [location]);

  return (
    <div className="relative">
      <BackgroundIcons />
      <main className="">

        <section className="">
          <div className="container mx-auto flex px-5 py-24 md:flex-row flex-col items-center">
            <div
              data-aos="fade-down-right"
              data-aos-duration="1000"
              className="lg:max-w-lg lg:w-full md:w-1/2 w-5/6 mb-10 md:mb-0"
            >
              <img
                className="object-cover object-center rounded"
                alt="hero"
                src={img9}
              />
            </div>
            <div
              data-aos="fade-down-left"
              data-aos-duration="1000"
              className="lg:flex-grow md:w-1/2 lg:pl-24 md:pl-16 flex flex-col md:items-start md:text-left items-center text-center"
            >
              <div ref={contactRef} className="">
                <h1
                  className="text-center title-font sm:text-5xl text-4xl mb-6 font-extrabold text-primary text-lang leading-tight transition-all duration-300 ease-in-out transform hover:scale-105 hover:text-secondary dark:hover:text-slate-200"
                  data-i18n="contact_us"
                >
                  {t("contact_us")}
                  <br className="hidden lg:inline-block" />
                </h1>
              </div>
              <p className="text-sm md:text-base text-justify mb-8 leading-relaxed text-gray-800 dark:text-gray-200">
                {t(webContent?.one) || "Content not available."}
              </p>
              <div className="flex justify-center">

                <button
                  className="ml-4 inline-flex items-center text-white bg-secondary border-0 py-2 px-6 focus:outline-none hover:scale-105 duration-300 rounded-full text-lg cursor-pointer"
                  onClick={() => window.open("https://t.me/monisakor", "_blank")}
                >
                  <span className="mr-2">{t("message")}</span>
                  <FaTelegram />
                </button>
              </div>
            </div>
          </div>
        </section>

        <section
          data-aos="fade-up"
          data-aos-duration="1000"
          className="text-gray-800 dark:text-gray-200 body-font relative">
          <div className="container px-5 py-24 mx-auto flex sm:flex-nowrap flex-wrap pt-0">
            <div

              className="lg:w-2/3 md:w-1/2 text-gray-800 dark:text-gray-200 rounded-lg overflow-hidden sm:mr-10 p-10 flex items-end justify-start relative"
            >
              <iframe
                width="100%"
                height="100%"
                className="absolute inset-0"
                title="map"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d11817.098262395657!2d105.9443957!3d11.0094809!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x310b1b5bc6f7e085:0x374e2cfa5d5e5235!2sSvay%20Ta%20Yean!5e0!3m2!1sen!2sus!4v1677163182827!5m2!1sen!2sus"
                style={{ filter: "grayscale(0) contrast(1.2)" }}
              ></iframe>

              <div className="pr-2 bg-white dark:bg-card-dark relative flex flex-wrap py-6 rounded shadow-md">
                <div className="lg:w-1/2 px-6">
                  <h2
                    className="title-font font-semibold text-gray-800 dark:text-gray-200 tracking-widest text-lg "
                    data-i18n="address"
                  >
                    {t("address")}
                  </h2>
                  <p
                    className="text-sm md:text-base text-justify mt-1 cursor-pointer "
                    onClick={() =>
                      window.open(
                        "https://www.google.com/maps?q=...your_address_here...",
                        "_blank"
                      )
                    }
                    data-i18n="location"
                  >
                    {t("location")}
                  </p>
                </div>
                <div className="lg:w-1/2 px-6 mt-4 lg:mt-0">
                  <h2 className="title-font font-semibold text-gray-800 dark:text-gray-200 tracking-widest text-lg ">
                    {t("tel")}
                  </h2>
                  <p
                    className="text-sm md:text-base text-justify leading-relaxed cursor-pointer"
                    onClick={() => (window.location.href = "tel:9844640316")}
                  >
                    9844640316
                  </p>
                </div>
              </div>
            </div>

            <div className="lg:w-1/3 md:w-1/2 w-full flex flex-col md:py-8 mt-8 md:mt-0 bg-white   dark:bg-[#1e1e1e] p-6 rounded-lg shadow-lg">
              <h2 className="text-primary text-lg font-semibold mb-2">
                {t("feedback")}
              </h2>
              <p className="text-gray-800 dark:text-gray-200 mb-4">
                {t("feedback_desc")}
              </p>

              <form onSubmit={handleSubmit} className="space-y-4">
                {Object.entries(formData).map(([key, value]) => (
                  <div key={key} className="relative">
                    <label
                      htmlFor={key}
                      className="text-sm font-medium text-gray-800 dark:text-gray-200"
                    >
                      {t(key)}
                    </label>

                    {key === "message" ? (
                      <textarea
                        required
                        name={key}
                        id={key}
                        value={value}
                        onChange={handleChange}
                        className="w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none resize-none"
                        rows="4"
                      />
                    ) : (
                      <input
                        required
                        type={key === "phone" ? "tel" : "text"}
                        name={key}
                        id={key}
                        value={value}
                        onChange={handleChange}
                        className="w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none"
                      />
                    )}

                    {formErrors[key] && (
                      <p className="text-red-500 text-lg mt-1">
                        {formErrors[key]}
                      </p>
                    )}
                  </div>
                ))}

                <button
                  type="submit"
                  className="w-full py-2 px-4 bg-primary text-white font-medium rounded-lg hover:bg-opacity-90 transition"
                >
                  {t("send")}
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
                            {t("success")}
                          </h3>
                          <div className="mt-2">
                            <p className="text-sm text-gray-800 dark:text-gray-200">
                              {t("thank_feedback")}
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
        </section>
      </main>
    </div>
  );
};

export default ContactUs;
