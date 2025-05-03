import React, { useEffect, useState, useRef} from "react";
import axios from "axios";
import "aos/dist/aos.css";
import {  useLocation } from "react-router-dom";
import img9 from "../assets/images/schoolImages/9.jpg";
import { useTranslation } from "react-i18next"; // Import useTranslation
import BackgroundIcons from "../components/BackgroundIcons";

const AboutUs = () => {
  // Define state for webContent and error
  const [webContent, setWebContent] = useState({});
  const [error, setError] = useState(null);
  const { t } = useTranslation(); // Use translation

  const { i18n } = useTranslation(); // Get language info from i18next

  useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await axios.get(
          `http://localhost:/project/monisakor-primary-school/server/api/AboutUs.php?lang=${i18n.language}`
        );
        setWebContent(response.data.web_content);
      } catch (error) {
        setError("Error fetching data, please try again later.");
        console.error("Error fetching data:", error.response || error.message || error);
      }
    };
  
    fetchData();
  }, [i18n.language]); // Refetch when language changes

// scroll to about section
   const aboutRef = useRef(null);
   const location = useLocation();
  
    useEffect(() => {
      if (location.hash === "#about" && aboutRef.current) {
        aboutRef.current.scrollIntoView({ behavior: "smooth" });
      }
    }, [location]);

  return (
    <div className="relative">
      <BackgroundIcons />
      {/* About Section */}
      <section className="py-16 px-8 md:px-32" data-aos="fade-up">
        <div className="container mx-auto flex px-5 py-5 md:flex-row flex-col items-center">
        
          <div ref={aboutRef} className="lg:flex-grow md:w-1/2 lg:pr-24 md:pr-16 flex flex-col md:items-start md:text-left mb-16 md:mb-0 items-center text-center">
            <h1 className="title-font sm:text-5xl text-4xl mb-6 font-extrabold text-primary text-lang leading-tight transition-all duration-300 ease-in-out transform hover:scale-105 hover:text-secondary dark:hover:text-slate-200">
              {t("history")}
            </h1>
            
            <p className="text-justify text-sm md:text-base mb-8 leading-relaxed text-gray-900 dark:text-gray-200 transition-all duration-300 ease-in-out hover:text-slate-600">
              {webContent.one}
            </p>
          </div>
          <div className="lg:max-w-lg lg:w-full md:w-1/2 w-5/6 shadow-lg rounded-xl overflow-hidden transition-transform duration-300 ease-in-out transform hover:scale-105">
            <img
              src={img9}
              alt="History Image"
              className="w-full h-full object-cover object-center rounded-lg shadow-lg transition-all duration-500 ease-in-out hover:opacity-80"
            />
          </div>
        </div>
      </section>

      <section className="py-16 px-6">
        <div className="container px-5 py-5 mx-auto">
          <div
            data-aos="fade-up"
            data-aos-duration="1000"
            className="text-center mb-10"
          >
            <h1
              className="title-font sm:text-5xl text-4xl mb-6 font-extrabold text-primary text-lang leading-tight transition-all duration-300 ease-in-out transform hover:scale-105 hover:text-secondary dark:hover:text-slate-200"
              data-i18n="rule_title"
            >
              {t("rule_title")}
            </h1>
            <p className="text-gray-900 dark:text-gray-200 text-justify text-sm md:text-base leading-relaxed xl:w-2/4 lg:w-3/4 mx-auto">
              {webContent.three}
            </p>
          </div>
        </div>
        <div className="flex flex-wrap lg:w-4/5 sm:mx-auto sm:mb-2 -mx-2">
          <div
            data-aos="fade-up"
            data-aos-duration="1000"
            className="p-2 sm:w-1/2 w-full"
          >
            <div className="bg-white   dark:bg-[#1e1e1e] shadow-lg rounded flex p-4 h-full items-center">
              <svg
                fill="none"
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="3"
                className="text-secondary w-6 h-6 flex-shrink-0 mr-4"
                viewBox="0 0 24 24"
              >
                <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>
                <path d="M22 4L12 14.01l-3-3"></path>
              </svg>
              {webContent ? (
                <span
                  data-aos="fade-right"
                  data-aos-duration="1000"
                  className="text-gray-800  dark:text-gray-200 text-sm md:text-base title-font font-medium"
                >
                  {webContent.four}
                </span>
              ) : (
                <span>Loading...</span>
              )}
            </div>
          </div>
          <div
            data-aos="fade-up"
            data-aos-duration="1000"
            className="p-2 sm:w-1/2 w-full"
          >
            <div className="bg-white   dark:bg-[#1e1e1e] shadow-lg  rounded flex p-4 h-full items-center">
              <svg
                fill="none"
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="3"
                className="text-secondary w-6 h-6 flex-shrink-0 mr-4"
                viewBox="0 0 24 24"
              >
                <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>
                <path d="M22 4L12 14.01l-3-3"></path>
              </svg>
              {webContent ? (
                <span
                  data-aos="fade-right"
                  data-aos-duration="1000"
                  className="text-gray-800  dark:text-gray-200 text-sm md:text-base title-font font-medium"
                >
                  {webContent.five}
                </span>
              ) : (
                <span>Loading...</span>
              )}
            </div>
          </div>

          <div
            data-aos="fade-up"
            data-aos-duration="1000"
            className="p-2 sm:w-1/2 w-full"
          >
            <div className="bg-white   dark:bg-[#1e1e1e] shadow-lg rounded flex p-4 h-full items-center">
              <svg
                fill="none"
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="3"
                className="text-secondary w-6 h-6 flex-shrink-0 mr-4"
                viewBox="0 0 24 24"
              >
                <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>
                <path d="M22 4L12 14.01l-3-3"></path>
              </svg>
              {webContent ? (
                <span
                  data-aos="fade-right"
                  data-aos-duration="1000"
                  className="text-gray-800  dark:text-gray-200 text-sm md:text-base title-font font-medium"
                >
                  {webContent.six}
                </span>
              ) : (
                <span>Loading...</span>
              )}
            </div>
          </div>

          <div
            data-aos="fade-up"
            data-aos-duration="1000"
            className="p-2 sm:w-1/2 w-full"
          >
            <div className="bg-white dark:bg-[#1e1e1e] shadow-lg rounded flex p-4 h-full items-center">
              <svg
                fill="none"
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="3"
                className="text-secondary w-6 h-6 flex-shrink-0 mr-4"
                viewBox="0 0 24 24"
              >
                <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>
                <path d="M22 4L12 14.01l-3-3"></path>
              </svg>
              {webContent ? (
                <span
                  data-aos="fade-right"
                  data-aos-duration="1000"
                  className="text-gray-800 dark:text-gray-200 text-sm md:text-base title-font font-medium"
                >
                  {webContent.seven}
                </span>
              ) : (
                <span>Loading...</span>
              )}
            </div>
          </div>

          <div
            data-aos="fade-up"
            data-aos-duration="1000"
            className="p-2 sm:w-1/2 w-full"
          >
            <div className="bg-white   dark:bg-[#1e1e1e] shadow-lg rounded flex p-4 h-full items-center">
              <svg
                fill="none"
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="3"
                className="text-secondary w-6 h-6 flex-shrink-0 mr-4"
                viewBox="0 0 24 24"
              >
                <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>
                <path d="M22 4L12 14.01l-3-3"></path>
              </svg>
              {webContent ? (
                <span
                  data-aos="fade-right"
                  data-aos-duration="1000"
                  className="text-gray-800 dark:text-gray-200 text-sm md:text-base title-font font-medium"
                >
                  {webContent.eight}
                </span>
              ) : (
                <span>Loading...</span>
              )}
            </div>
          </div>

          <div
            data-aos="fade-up"
            data-aos-duration="1000"
            className="p-2 sm:w-1/2 w-full"
          >
            <div className="bg-white   dark:bg-[#1e1e1e] shadow-lg rounded flex p-4 h-full items-center">
              <svg
                fill="none"
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="3"
                className="text-secondary w-6 h-6 flex-shrink-0 mr-4"
                viewBox="0 0 24 24"
              >
                <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>
                <path d="M22 4L12 14.01l-3-3"></path>
              </svg>
              {webContent ? (
                <span
                  data-aos="fade-right"
                  data-aos-duration="1000"
                  className="text-gray-800 dark:text-gray-200 text-sm md:text-base title-font font-medium"
                >
                  {webContent.nine}
                </span>
              ) : (
                <span>Loading...</span>
              )}
            </div>
          </div>

          <div
            data-aos="fade-up"
            data-aos-duration="1000"
            className="p-2 sm:w-1/2 w-full"
          >
            <div className="bg-white   dark:bg-[#1e1e1e] shadow-lg rounded flex p-4 h-full items-center">
              <svg
                fill="none"
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="3"
                className="text-secondary w-6 h-6 flex-shrink-0 mr-4"
                viewBox="0 0 24 24"
              >
                <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>
                <path d="M22 4L12 14.01l-3-3"></path>
              </svg>
              {webContent ? (
                <span
                  data-aos="fade-right"
                  data-aos-duration="1000"
                  className="text-gray-800 dark:text-gray-200 text-sm md:text-base title-font font-medium"
                >
                  {webContent.ten}
                </span>
              ) : (
                <span>Loading...</span>
              )}
            </div>
          </div>

          <div
            data-aos="fade-up"
            data-aos-duration="1000"
            className="p-2 sm:w-1/2 w-full"
          >
            <div className="bg-white   dark:bg-[#1e1e1e] shadow-lg rounded flex p-4 h-full items-center">
              <svg
                fill="none"
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="3"
                className="text-secondary w-6 h-6 flex-shrink-0 mr-4"
                viewBox="0 0 24 24"
              >
                <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>
                <path d="M22 4L12 14.01l-3-3"></path>
              </svg>
              {webContent ? (
                <span
                  data-aos="fade-right"
                  data-aos-duration="1000"
                  className="text-gray-800 dark:text-gray-200 text-sm md:text-base title-font font-medium"
                >
                  {webContent.eleven}
                </span>
              ) : (
                <span>Loading...</span>
              )}
            </div>
          </div>

          <div
            data-aos="fade-up"
            data-aos-duration="1000"
            className="p-2 sm:w-1/2 w-full"
          >
            <div className="bg-white   dark:bg-[#1e1e1e] shadow-lg rounded flex p-4 h-full items-center">
              <svg
                fill="none"
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="3"
                className="text-secondary w-6 h-6 flex-shrink-0 mr-4"
                viewBox="0 0 24 24"
              >
                <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>
                <path d="M22 4L12 14.01l-3-3"></path>
              </svg>
              {webContent ? (
                <span
                  data-aos="fade-right"
                  data-aos-duration="1000"
                  className="text-gray-800 dark:text-gray-200 text-sm md:text-base title-font font-medium"
                >
                  {webContent.twelve}
                </span>
              ) : (
                <span>Loading...</span>
              )}
            </div>
          </div>

          <div
            data-aos="fade-up"
            data-aos-duration="1000"
            className="p-2 sm:w-1/2 w-full"
          >
            <div className="bg-white   dark:bg-[#1e1e1e] shadow-lg rounded flex p-4 h-full items-center">
              <svg
                fill="none"
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="3"
                className="text-secondary w-6 h-6 flex-shrink-0 mr-4"
                viewBox="0 0 24 24"
              >
                <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>
                <path d="M22 4L12 14.01l-3-3"></path>
              </svg>
              {webContent ? (
                <span
                  data-aos="fade-right"
                  data-aos-duration="1000"
                  className="text-gray-800 dark:text-gray-200 text-sm md:text-base title-font font-medium"
                >
                  {webContent.thirteen}
                </span>
              ) : (
                <span>Loading...</span>
              )}
            </div>
          </div>

          <div
            data-aos="fade-up"
            data-aos-duration="1000"
            className="p-2 sm:w-1/2 w-full"
          >
            <div className="bg-white   dark:bg-[#1e1e1e] shadow-lg rounded flex p-4 h-full items-center">
              <svg
                fill="none"
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="3"
                className="text-secondary w-6 h-6 flex-shrink-0 mr-4"
                viewBox="0 0 24 24"
              >
                <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>
                <path d="M22 4L12 14.01l-3-3"></path>
              </svg>
              {webContent ? (
                <span
                  data-aos="fade-right"
                  data-aos-duration="1000"
                  className="text-gray-800 dark:text-gray-200 text-sm md:text-base title-font font-medium"
                >
                  {webContent.fourteen}
                </span>
              ) : (
                <span>Loading...</span>
              )}
            </div>
          </div>

          <div
            data-aos="fade-up"
            data-aos-duration="1000"
            className="p-2 sm:w-1/2 w-full"
          >
            <div className="bg-white   dark:bg-[#1e1e1e] shadow-lg rounded flex p-4 h-full items-center">
              <svg
                fill="none"
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="3"
                className="text-secondary w-6 h-6 flex-shrink-0 mr-4"
                viewBox="0 0 24 24"
              >
                <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>
                <path d="M22 4L12 14.01l-3-3"></path>
              </svg>
              {webContent ? (
                <span
                  data-aos="fade-right"
                  data-aos-duration="1000"
                  className="text-gray-800 dark:text-gray-200 text-sm md:text-base title-font font-medium"
                >
                  {webContent.fifteen}
                </span>
              ) : (
                <span>Loading...</span>
              )}
            </div>
          </div>

          <div
            data-aos="fade-up"
            data-aos-duration="1000"
            className="p-2 sm:w-1/2 w-full"
          >
            <div className="bg-white   dark:bg-[#1e1e1e] shadow-lg rounded flex p-4 h-full items-center">
              <svg
                fill="none"
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="3"
                className="text-secondary w-6 h-6 flex-shrink-0 mr-4"
                viewBox="0 0 24 24"
              >
                <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>
                <path d="M22 4L12 14.01l-3-3"></path>
              </svg>
              {webContent ? (
                <span
                  data-aos="fade-right"
                  data-aos-duration="1000"
                  className="text-gray-800 dark:text-gray-200 text-sm md:text-base title-font font-medium"
                >
                  {webContent.sixteen}
                </span>
              ) : (
                <span>Loading...</span>
              )}
            </div>
          </div>

          <div
            data-aos="fade-up"
            data-aos-duration="1000"
            className="p-2 sm:w-1/2 w-full"
          >
            <div className="bg-white   dark:bg-[#1e1e1e] shadow-lg rounded flex p-4 h-full items-center">
              <svg
                fill="none"
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="3"
                className="text-secondary w-6 h-6 flex-shrink-0 mr-4"
                viewBox="0 0 24 24"
              >
                <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>
                <path d="M22 4L12 14.01l-3-3"></path>
              </svg>
              {webContent ? (
                <span
                  data-aos="fade-right"
                  data-aos-duration="1000"
                  className="text-gray-800 dark:text-gray-200 text-sm md:text-base title-font font-medium"
                >
                  {webContent.seventeen}
                </span>
              ) : (
                <span>Loading...</span>
              )}
            </div>
          </div>

          <div
            data-aos="fade-up"
            data-aos-duration="1000"
            className="p-2 sm:w-1/2 w-full"
          >
            <div className="bg-white   dark:bg-[#1e1e1e] shadow-lg rounded flex p-4 h-full items-center">
              <svg
                fill="none"
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="3"
                className="text-secondary w-6 h-6 flex-shrink-0 mr-4"
                viewBox="0 0 24 24"
              >
                <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>
                <path d="M22 4L12 14.01l-3-3"></path>
              </svg>
              {webContent ? (
                <span
                  data-aos="fade-right"
                  data-aos-duration="1000"
                  className="text-gray-800 dark:text-gray-200 text-sm md:text-base title-font font-medium"
                >
                  {webContent.eighteen}
                </span>
              ) : (
                <span>Loading...</span>
              )}
            </div>
          </div>
        </div>
      </section>
    </div>
  );
};

export default AboutUs;
