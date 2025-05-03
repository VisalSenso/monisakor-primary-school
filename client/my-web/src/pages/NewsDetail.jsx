import React, { useEffect, useState } from "react";
import { useLocation, useNavigate } from "react-router-dom";
import axios from "axios";
import { useTranslation } from "react-i18next";

const decodeHTML = (html) => {
  const txt = document.createElement("textarea");
  txt.innerHTML = html;
  return txt.value;
};

const NewsDetail = () => {
  const location = useLocation();
  const params = new URLSearchParams(location.search);
  const newsId = params.get("id");
  const navigate = useNavigate();
  const { t, i18n } = useTranslation();

  const [newsDetail, setNewsDetail] = useState(null);
  const [recentNews, setRecentNews] = useState([]);
  const [trendingNews, setTrendingNews] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState("");
  const [selectedNews, setSelectedNews] = useState(null);
  const [selectedNewsId, setSelectedNewsId] = useState(null);

  // Fetch main news detail on page load
  useEffect(() => {
    const fetchNewsDetail = async () => {
      try {
        const response = await axios.get(
          `http://localhost/project/monisakor-primary-school/server/api/getNewsDetail.php?id=${newsId}&lang=${i18n.language}`
        );
        setNewsDetail(response.data);
        setSelectedNews(null); // reset if it's different from main page load
      } catch (error) {
        setError("Error fetching news details.");
        console.error("Fetch error:", error);
      } finally {
        setLoading(false);
      }
    };

    if (newsId) {
      fetchNewsDetail();
    }
  }, [newsId, i18n.language]);

  // Fetch selected recent/trending news dynamically
  useEffect(() => {
    const fetchSelectedNews = async () => {
      if (!selectedNewsId) return;
      try {
        const response = await axios.get(
          `http://localhost/project/monisakor-primary-school/server/api/getNewsDetail.php?id=${selectedNewsId}&lang=${i18n.language}`
        );
        setSelectedNews(response.data);
      } catch (error) {
        console.error("Error fetching selected news:", error);
      }
    };

    fetchSelectedNews();
  }, [selectedNewsId, i18n.language]);

  // Fetch recent and trending news
  useEffect(() => {
    const fetchRecentNews = async () => {
      try {
        const response = await axios.get(
          `http://localhost/project/monisakor-primary-school/server/api/getRecentNews.php?lang=${i18n.language}`
        );
        setRecentNews(response.data.recentNews);
      } catch (error) {
        console.error("Error fetching recent news:", error);
      }
    };

    const fetchTrendingNews = async () => {
      try {
        const response = await axios.get(
          `http://localhost/project/monisakor-primary-school/server/api/getTrendingNews.php?lang=${i18n.language}`
        );
        setTrendingNews(response.data.trendingNews);
      } catch (error) {
        console.error("Error fetching trending news:", error);
      }
    };

    fetchRecentNews();
    fetchTrendingNews();
  }, [i18n.language]);

  const handleRecentNewsClick = (id) => {
    navigate(`/newsdetail?id=${id}`);
    setSelectedNewsId(id);
    setSelectedNews(null);
  };

  if (loading)
    return (
      <div className="text-center py-12 text-lg font-semibold text-gray-500 dark:text-gray-300">
        Loading...
      </div>
    );

  if (error || (!newsDetail && !selectedNews))
    return (
      <div className="text-center py-12 text-lg font-semibold text-red-600 dark:text-red-400">
        {error || "News not found"}
      </div>
    );

  const currentNewsDetail = selectedNews || newsDetail;

  return (
    <div className="container mx-auto mt-24 px-6 md:px-12 lg:px-24 flex flex-col md:flex-row gap-12">
      {/* News Detail */}
      <div className="w-full md:w-2/3">
        <h1 className="text-3xl md:text-3xl font-extrabold text-gray-900 dark:text-white mb-4">
          {currentNewsDetail.about}
        </h1>
        <p className="text-sm text-gray-600 dark:text-gray-400 mb-6">
          {currentNewsDetail.time} | {currentNewsDetail.date}
        </p>
        <img
          src={`http://localhost:/project/monisakor-primary-school/assects/images/notices_files/${currentNewsDetail.image_url.replace(
            /^.*[\\\/]/,
            ""
          )}`}
          alt={currentNewsDetail.about}
          className="w-full h-96 object-cover rounded-xl shadow-xl mb-8"
        />
        <div className="prose lg:prose-lg dark:prose-invert max-w-none text-gray-800 dark:text-gray-300">

          <span
            dangerouslySetInnerHTML={{
              __html: decodeHTML(currentNewsDetail.notice_description)
            }}
          />
        </div>
      </div>

      {/* Sidebar */}
      <aside className="w-full md:w-1/3 border-t md:border-t-0 md:border-l border-gray-200 dark:border-gray-700 md:pl-8">
        {/* Recent News */}
        <h2 className="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-6">
          {t("recent_news")}
        </h2>
        {recentNews.length > 0 ? (
          <div className="divide-y divide-gray-200 dark:divide-gray-700 mb-10">
            {recentNews.map((news) => (
              <div
                key={news.id}
                onClick={() => handleRecentNewsClick(news.id)}
                className="cursor-pointer flex flex-col sm:flex-row items-start gap-4 py-4 hover:bg-gray-50 dark:hover:bg-gray-800 transition"
              >
                <img
                  src={`http://localhost:/project/monisakor-primary-school/assects/images/notices_files/${news.image_url.replace(
                    /^.*[\\\/]/,
                    ""
                  )}`}
                  alt={news.about}
                  className="w-full sm:w-28 h-20 object-cover rounded-lg"
                />
                <div className="flex-1">
                  <h3 className="text-base font-semibold text-gray-900 dark:text-white line-clamp-2">
                    {news.about}
                  </h3>
                  <p className="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    {news.date}
                  </p>
                </div>
              </div>
            ))}
          </div>
        ) : (
          <p className="text-gray-500 dark:text-gray-400">No recent news available.</p>
        )}

        {/* Trending News */}
        <div className="border-t pt-8 dark:border-gray-700">
          <h2 className="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-6">
            {t("trending_news")}
          </h2>
          {trendingNews.length > 0 ? (
            <div className="divide-y divide-gray-200 dark:divide-gray-700">
              {trendingNews.map((item) => (
                <div
                  key={item.id}
                  onClick={() => handleRecentNewsClick(item.id)}
                  className="cursor-pointer flex flex-col sm:flex-row items-start gap-4 py-4 hover:bg-gray-50 dark:hover:bg-gray-800 transition"
                >
                  <img
                    src={`http://localhost:/project/monisakor-primary-school/assects/images/notices_files/${item.image_url.replace(
                      /^.*[\\\/]/,
                      ""
                    )}`}
                    alt={item.about}
                    className="w-full sm:w-28 h-20 object-cover rounded-lg"
                  />
                  <div className="flex-1">
                    <h3 className="text-base font-semibold text-gray-900 dark:text-white line-clamp-2">
                      {item.about}
                    </h3>
                    <p className="text-sm text-gray-500 dark:text-gray-400 mt-1">
                      {item.date}
                    </p>
                  </div>
                </div>
              ))}
            </div>
          ) : (
            <p className="text-gray-500 dark:text-gray-400">No trending news available.</p>
          )}
        </div>
      </aside>
    </div>
  );
};

export default NewsDetail;
