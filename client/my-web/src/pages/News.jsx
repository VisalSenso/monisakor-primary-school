import React, { useState, useEffect, useRef } from "react";
import axios from "axios";
import { useTranslation } from "react-i18next";
import { Link, useLocation } from "react-router-dom";
import BackgroundIcons from "../components/BackgroundIcons";
const decodeHTML = (html) => {
  const txt = document.createElement("textarea");
  txt.innerHTML = html;
  return txt.value;
};

const News = () => {
  const [notices, setNotices] = useState([]);
  const [searchTerm, setSearchTerm] = useState("");
  const [error, setError] = useState(null);
  const { t } = useTranslation();
  const [currentPage, setCurrentPage] = useState(1);
  const noticesPerPage = 5;

  // Fetch data only once when component mounts
  const { i18n } = useTranslation(); // Access i18n instance for language

  useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await axios.get(
          `http://localhost/project/monisakor-primary-school/server/api/home.php?lang=${i18n.language}`
        );
        setNotices(response.data.notices || []);
      } catch (error) {
        setError("Error fetching data, please try again later.");
        console.error(
          "Error fetching data:",
          error.response || error.message || error
        );
      }
    };

    fetchData();
  }, [i18n.language]); // Re-fetch data when language changes


  // Filter notices based on search term
  const filteredNotices = notices.filter((notice) =>
    `${notice.about} ${notice.notice_description} ${notice.date} ${notice.time}`
      .toLowerCase()
      .includes(searchTerm.toLowerCase())
  );

  // Calculate pagination
  const totalPages = Math.max(
    1,
    Math.ceil(filteredNotices.length / noticesPerPage)
  );
  const paginatedNotices = filteredNotices.slice(
    (currentPage - 1) * noticesPerPage,
    currentPage * noticesPerPage
  );

  const handlePrevPage = () => {
    setCurrentPage((prevPage) => (prevPage > 1 ? prevPage - 1 : prevPage));
  };

  const handleNextPage = () => {
    setCurrentPage((prevPage) =>
      prevPage < totalPages ? prevPage + 1 : prevPage
    );
  }

  //scroll to news section
  const newsRef = useRef(null);
  const location = useLocation();

  useEffect(() => {
    if (location.hash === "#news" && newsRef.current) {
      newsRef.current.scrollIntoView({ behavior: "smooth" });
    }
  }, [location]);

  if (error) {
    return <div className="text-center text-red-400">{error}</div>;
  }

  return (
    <div className="relative">
      <BackgroundIcons />

      {/* <section className="relative bg-amber-300">
              <img
                src={slide2}
                alt="Monisakor Primary School"
                className="w-full h-[500px] object-cover"
              />
              <div className="absolute inset-0 bg-black  opacity-70 flex flex-col justify-center items-center text-white text-center px-4"></div>
      
              <div
                data-aos="fade-up"
                data-aos-duration="1000"
                className="absolute inset-0  opacity-100 flex flex-col justify-center items-center text-white text-center px-4"
              >
               <h2 className="text-3xl font-bold ">{t("news_intro")}</h2>
               <p className="mt-2 text-lg">{t("news_intro_desc")}</p>
              </div>
            </section> */}

      <div className="container mx-auto px-4 md:px-10 lg:px-30 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 w-full mb-10">
        {/* Header Section */}

        <div
          data-aos="fade-up"
          data-aos-duration="1000"
          className="w-full col-span-1 sm:col-span-2 lg:col-span-3 mt-6"
        >
          <div className="flex flex-col md:flex-row justify-between items-center gap-4">
            <div ref={newsRef} className="news-section">
              <h1 className="text-2xl md:text-3xl font-extrabold text-primary">{t("news")}</h1>

            </div>
            <div className="relative w-full sm:w-auto">
              <input
                className="w-full sm:w-64 md:w-80 bg-white dark:bg-card-dark text-gray-800 dark:text-gray-200 text-sm border border-gray-300 rounded-full pl-3 pr-10 py-2 focus:ring-2 focus:ring-primary focus:border-primary outline-none"
                placeholder={t("search_news")}
                value={searchTerm}
                onChange={(e) => setSearchTerm(e.target.value)}
              />
              <button
                className="absolute top-1/2 right-1 transform -translate-y-1/2 bg-primary text-white p-2 rounded-full hover:bg-blue-400"
                type="button"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 24 24"
                  fill="currentColor"
                  className="w-4 h-4"
                >
                  <path
                    fillRule="evenodd"
                    d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z"
                    clipRule="evenodd"
                  />
                </svg>
              </button>
            </div>

          </div>
          <div className="h-1 bg-secondary mt-4"></div>
        </div>

        {/* News Section */}
        {paginatedNotices.length > 0 ? (
          <>
            {/* Featured News */}
            <div
              key={paginatedNotices[0].id}
              className="lg:col-span-3 md:col-span-2"
            >
              <Link
                to={`/newsdetail?id=${encodeURIComponent(
                  paginatedNotices[0].id
                )}`}
                data-aos="fade-up"
                data-aos-duration="1000"
                className="group block"
              >
                <div className="relative flex flex-col md:flex-row bg-white dark:bg-card-dark shadow-lg rounded-lg overflow-hidden">
                  <div className="w-full md:w-1/2 h-64 md:h-80 bg-gray-800">
                    <img
                      className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                      src={
                        paginatedNotices[0].image_url
                          ? `http://localhost/project/monisakor-primary-school/assects/images/notices_files/${paginatedNotices[0].image_url.replace(
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
                      {paginatedNotices[0].about}
                    </h2>
                    <p className="text-xs font-semibold text-gray-600 dark:text-gray-300">
                      {paginatedNotices[0].time} &#160;&#160;{" "}
                      {paginatedNotices[0].date}
                    </p>
                    <p className="mt-2 text-sm md:text-base text-gray-800 dark:text-gray-200 line-clamp-3">
                      <span
                          dangerouslySetInnerHTML={{
                            __html: decodeHTML(paginatedNotices[0].notice_description)
                          }}
                        />
                    </p>
                  </div>
                </div>
              </Link>
            </div>

            {/* Small News Cards */}
            {paginatedNotices.slice(1, 4).map((row) => (
              <div
                key={row.id}
                className="bg-white dark:bg-card-dark shadow-lg rounded-lg overflow-hidden z-10"
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
                      <p className="text-xs font-semibold text-gray-600 dark:text-gray-300">
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

      <div className="flex space-x-1 justify-center pb-10 sm:pt-10 md:pt-10 lg:pt-10 ">
        <button
          onClick={handlePrevPage}
          disabled={currentPage === 1}
          className="rounded-full border border-slate-300 py-2 px-3 text-center text-sm transition-all shadow-sm hover:shadow-lg text-slate-600 hover:text-white hover:bg-slate-800 hover:border-slate-800 focus:text-white focus:bg-slate-800 focus:border-slate-800 active:border-slate-800 active:text-white active:bg-slate-800 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none ml-2 cursor-pointer z-10"
        >
          {t("prev")}
        </button>

        {/* Page Numbers */}
        {[...Array(totalPages)].map((_, index) => {
          const pageNumber = index + 1;
          return (
            <button
              key={pageNumber}
              onClick={() => handlePageClick(pageNumber)}
              className={`min-w-9 rounded-full py-2 px-3.5 text-center text-sm transition-all shadow-sm ${currentPage === pageNumber
                ? "bg-slate-800 text-white"
                : "border border-slate-300 text-slate-600 hover:text-white hover:bg-slate-800 hover:border-slate-800 cursor-pointer z-10"
                }`}
            >
              {pageNumber}
            </button>
          );
        })}

        <button
          onClick={handleNextPage}
          disabled={currentPage === totalPages}
          className="rounded-full border border-slate-300 py-2 px-3 text-center text-sm transition-all shadow-sm hover:shadow-lg text-slate-600 hover:text-white hover:bg-slate-800 hover:border-slate-800 focus:text-white focus:bg-slate-800 focus:border-slate-800 active:border-slate-800 active:text-white active:bg-slate-800 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none ml-2 cursor-pointer z-10"
        >
          {t("next")}
        </button>
      </div>
    </div>
  );
};

export default News;
