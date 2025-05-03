import React from "react";
import { useTranslation } from "react-i18next";
import Logo from "../assets/images/schoolImages/logo.png";

const Footer = () => {
  const currentYear = new Date().getFullYear();
  const { t } = useTranslation();

  const handleLocationClick = () => {
    // Replace with your location map logic
    console.log("Opening location map");
  };

  const handleCallSchool = () => {
    // Replace with your phone call logic
    console.log("Calling the school");
  };

  const handleMailSchool = () => {
    // Replace with your mail logic
    console.log("Sending an email to the school");
  };

  return (
    <footer className="bg-background-dark text-gray-400 body-font border-t ">
      <div className="container flex justify-between px-5 py-10 mx-auto md:items-start lg:items-start md:flex-row flex-wrap flex-col space-y-10 md:space-y-0 md:space-x-10">
        {/* Logo and Description */}
        <div
          data-aos="fade-up"
          data-aos-duration="1000"
          className="w-[400px] flex-shrink-0 md:mx-0 mx-auto text-center md:text-left"
        >
          <a className="flex title-font font-medium items-center md:justify-start justify-center text-gray-900">
            <img
              src={Logo}
              alt="Logo"
              className="w-30 h-30 rounded-full shadow-lg"
            />
            <span
              className="ml-4 text-2xl text-white font-bold "
             
            >
              {t("school_title")}
            </span>
          </a>
          <p className="mt-4 text-base text-gray-400 leading-relaxed ">
           {t("descr")}
          </p>
        </div>

        {/* Contact Information */}
        <div
          data-aos="fade-up"
          data-aos-duration="1000"
          className="lg:w-1/4 md:w-1/2 w-full px-6"
        >
          <h2 className="font-bold text-white text-lg mb-5 ">
            {t("contact_us")}
          </h2>
          <nav className="list-none space-y-3">
            <li>
              <button
                onClick={handleLocationClick}
                className="hover:text-white transition hover:underline transform duration-300 cursor-pointer "
             
              >
                {t("location")}
              </button>
            </li>
            <li>
              <button
                onClick={handleCallSchool}
                className="hover:text-white transition hover:underline transform duration-300 cursor-pointer"
              >
                9844640316
              </button>
            </li>
            <li>
              <button
                onClick={handleMailSchool}
                className="hover:text-white transition hover:underline transform duration-300 cursor-pointer"
              >
                monisakor@gmail.com
              </button>
            </li>
          </nav>
        </div>

        {/* Social Media Links */}
        <div
          data-aos="fade-up"
          data-aos-duration="1000"
          className="lg:w-1/4 md:w-1/2 w-full px-6"
        >
          <h2 className="font-bold text-white text-lg mb-5 " >
            {t("link")}
          </h2>
          <div className="flex space-x-5">
            <a href="https://web.facebook.com/profile.php?id=100075849622350">
              <div className="group relative inline-block">
                <button className="focus:outline-none h-8 w-8 rounded-full hover:bg-blue-500 flex items-center justify-center transform transition-transform duration-300 hover:scale-125 group">
                  <svg
                    className="bi bi-facebook group-hover:text-white"
                    aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    fill="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      fillRule="evenodd"
                      d="M13.135 6H15V3h-1.865a4.147 4.147 0 0 0-4.142 4.142V9H7v3h2v9.938h3V12h2.021l.592-3H12V6.591A.6.6 0 0 1 12.592 6h.543Z"
                      clipRule="evenodd"
                    />
                  </svg>
                </button>
                <span className="absolute -top-14 left-1/2 transform -translate-x-1/2 z-20 px-4 py-2 text-sm font-bold text-white bg-gray-900 rounded-lg shadow-lg transition-transform duration-300 ease-in-out scale-0 group-hover:scale-100">
                  Facebook
                </span>
              </div>
            </a>
          </div>
        </div>
      </div>

      {/* Footer Bottom Section */}
      <div className="bg-black dark:bg-foot-dark">
        <div className="container mx-auto py-4 px-5 flex flex-wrap flex-col sm:flex-row items-center">
          <p className="text-gray-500 text-sm text-center sm:text-left ">
           {t("copy_right")}
            <a href="#" className="text-white ml-1" rel="noopener noreferrer">
            {t("school_title")}
            </a>
          </p>
        </div>
      </div>
    </footer>
  );
};

export default Footer;
