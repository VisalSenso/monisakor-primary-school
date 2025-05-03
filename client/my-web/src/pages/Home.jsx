import React, { useState, useEffect } from "react";
import axios from "axios";
import { useTranslation } from "react-i18next"; // Import useTranslation
import { Link } from "react-router-dom";
import img9 from "../assets/images/schoolImages/9.jpg";
import BackgroundIcons from "../components/BackgroundIcons";

const decodeHTML = (html) => {
  const txt = document.createElement("textarea");
  txt.innerHTML = html;
  return txt.value;
};

const Home = () => {
  const [webContent, setWebContent] = useState({});
  const [flashNotice, setFlashNotice] = useState({});
  const [notices, setNotices] = useState([]);
  const { t } = useTranslation(); // Use translation
  const [error, setError] = useState(null);
  const [showAll, setShowAll] = useState(false); // State to handle "Show More" functionality
  const { i18n } = useTranslation();
  const [content, setContent] = useState({});

  useEffect(() => {
    const fetchData = async () => {
      try {
        // Fetch translations
        const translationsResponse = await fetch(
          `http://localhost/project/monisakor-primary-school/server/api/translations.php?lang=${i18n.language}`
        );
        const translationsData = await translationsResponse.json();
        setContent(translationsData);

        // Fetch other content based on the current language
        const homeResponse = await axios.get(
          `http://localhost/project/monisakor-primary-school/server/api/home.php?lang=${i18n.language}`
        );
        setWebContent(homeResponse.data.web_content || {});
        setFlashNotice(homeResponse.data.flash_notice || {});
        setNotices(homeResponse.data.notices || []);
      } catch (error) {
        setError("Error fetching data, please try again later.");
        console.error("Error fetching data:", error.response || error.message || error);
      }
    };

    fetchData();
  }, [i18n.language]); // Re-fetch data when language changes

  if (error) {
    return <div className="text-center text-red-400">{error}</div>; // Show error message if there's any
  }

  const visibleNotices = showAll ? notices : notices.slice(0, 3); // Show only first 3 notices if not showing all

  return (
    <div className="relative">
      <BackgroundIcons />

      {/* Vision and Mission Section */}
      <div className="container mx-auto mt-8 mb-8 px-4 sm:px-6 lg:px-8 w-full md:w-11/12 ">
        {/* Vision Section */}
        <div className="flex flex-col md:flex-row justify-between items-center m-4 sm:m-8 md:m-16 group">
          {/* Image */}
          <div
            data-aos="fade-right"
            data-aos-duration="1000"
            className="w-full md:w-1/2 lg:w-5/12 rounded-md overflow-hidden shadow-xl transition-all duration-500 ease-in-out transform group-hover:scale-105 group-hover:shadow-2xl">
            <img
              className="object-cover w-full h-full group-hover:scale-110 transition-transform duration-500 ease-in-out"
              src={img9}
              alt="Vision"
            />
          </div>

          {/* Text */}
          <div
            data-aos="fade-left"
            data-aos-duration="1000"
            className="w-full md:w-1/2 lg:w-7/12 md:pl-6 lg:pl-20 mt-6 md:mt-0">
            <h1 className="text-secondary text-3xl sm:text-3xl md:text-4xl mb-4 sm:mb-6 font-extrabold leading-tight ">
              {t("vision")}
            </h1>
            <p className="text-justify text-lg sm:text-xl md:text-2xl lg:text-xl mt-2 sm:mt-4 text-gray-800 dark:text-slate-300 leading-relaxed transition-all duration-300 ease-in-out">
              {content.one}
            </p>

          </div>
        </div>


        {/* Mission Section */}
        <div className="flex flex-col-reverse md:flex-row justify-between items-center m-4 sm:m-8 md:m-16 group">
          {/* Text */}
          <div
            data-aos="fade-right"
            data-aos-duration="1000"
            className="w-full md:w-1/2 lg:w-7/12 md:pr-6 lg:pr-20 mt-6 md:mt-0">
            <h1 className="text-primary text-3xl sm:text-3xl md:text-4xl mb-4 sm:mb-6 font-extrabold leading-tight ">
              {t("mission")}
            </h1>
            <p className="text-justify text-lg sm:text-xl md:text-2xl lg:text-xl mt-2 sm:mt-4 text-gray-800 dark:text-slate-300 leading-relaxed transition-all duration-500 ease-in-out">
              {content.two}
            </p>
            
          </div>

          {/* Image */}
          <div
            data-aos="fade-left"
            data-aos-duration="1000"
            className="w-full md:w-1/2 lg:w-5/12 rounded-md overflow-hidden shadow-lg transition-all duration-500 ease-in-out transform group-hover:scale-105 group-hover:shadow-2xl">
            <img
              className="object-cover w-full h-full group-hover:scale-110 transition-transform duration-500 ease-in-out"
              src={img9}
              alt="Mission"
            />
          </div>
        </div>

      </div>




      {/* Notices Section */}

      <div className="container mx-auto px-4 md:px-10 lg:px-30 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 w-full mb-10 z-10">
        <Link
          to="/news"
          data-aos="fade-up"
          data-aos-duration="1000"
          className="w-full col-span-1 sm:col-span-2 lg:col-span-3 mt-6 group"
        >
          <div
            className="flex items-center group">
            <h1 className="text-2xl md:text-2xl sm:text-xs font-extrabold text-primary group">
              {t("moreevents")}
            </h1>
            <svg
              className="w-6 h-6 text-primary dark:text-white group-hover:translate-x-1 transition-transform duration-300"
              aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
            >
              <path
                stroke="currentColor"
                strokeLinecap="round"
                strokeLinejoin="round"
                strokeWidth="2"
                d="M9 5l7 7-7 7"
              />
            </svg>
          </div>

          <div>
            <div className="h-1 bg-secondary mt-4 "></div>
          </div>
        </Link>
        {notices.length > 0 ? (
          <>
            {/* Featured News */}
            <div key={notices[0].id} className="lg:col-span-3 md:col-span-2">
              <Link
                to={`/newsdetail?id=${encodeURIComponent(notices[0].id)}`}
                data-aos="fade-up"
                data-aos-duration="1000"
                className="group block"
              >
                <div className="relative flex flex-col md:flex-row bg-card-light dark:bg-card-dark shadow-lg rounded-lg overflow-hidden">
                  <div className="w-full md:w-1/2 h-64 md:h-80 bg-gray-800">
                    <img
                      className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                      src={
                        notices[0].image_url
                          ? `http://localhost/project/monisakor-primary-school/assects/images/notices_files/${notices[0].image_url.replace(
                            /^.*[\\\/]/,
                            ""
                          )}`
                          : "path-to-fallback-image.jpg"
                      }
                      alt="Card Image"
                    />
                  </div>
                  <div className="w-full md:w-1/2 p-6">
                    <h2 className="text-xl md:text-2xl font-bold text-gray-800 dark:text-gray-200">
                      {notices[0].about}
                    </h2>
                    <p className="text-xs font-semibold ">
                      {notices[0].time} &#160;&#160; {notices[0].data}
                    </p>
                    <p className="mt-2 text-sm md:text-base text-gray-800 dark:text-gray-200 line-clamp-3">
                      <span
                        dangerouslySetInnerHTML={{
                          __html: decodeHTML(notices[0].notice_description)
                        }}
                      />
                    </p>
                  </div>
                </div>
              </Link>
            </div>

            {/* Small News Cards */}
            {notices.slice(1, 4).map((row) => (
              <div
                key={row.id}
                className="bg-white   dark:bg-card-dark shadow-lg rounded-lg overflow-hidden z-10"
              >
                <Link
                  to={`/newsdetail?id=${encodeURIComponent(row.id)}`}
                  data-aos="fade-up"
                  data-aos-duration="1000"
                  className="group block"
                >
                  <div className="relative flex flex-col">
                    <div className="w-full h-48 bg-gray-800">
                      <img
                        className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                        src={
                          row.image_url
                            ? `http://localhost/project/monisakor-primary-school/assects/images/notices_files/${row.image_url.replace(
                              /^.*[\\\/]/,
                              ""
                            )}`
                            : "https://via.placeholder.com/150"
                        }
                        alt="Card Image"
                      />
                    </div>
                    <div className="p-4">
                      <h2 className="text-lg font-bold text-gray-800 dark:text-gray-200">
                        {row.about}
                      </h2>
                      <p className="text-xs font-semibold ">
                        {row.time} &#160;&#160; {row.date}
                      </p>
                      <p className="mt-2 text-sm text-gray-800 dark:text-gray-200 line-clamp-3">
                        <span
                          dangerouslySetInnerHTML={{
                            __html: decodeHTML(row.notice_description)
                          }}
                        />
                      </p>

                    </div>
                  </div>
                </Link>
              </div>
            ))}
          </>
        ) : (
          <div className="text-center py-4 text-lg font-semibold">
            {t("No Notices")}
          </div>
        )}
      </div>
    </div>
  );
};

export default Home;
