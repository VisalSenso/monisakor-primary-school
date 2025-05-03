import React, { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import { useTranslation } from "react-i18next";

const Gallery = () => {
  const [albums, setAlbums] = useState([]);
  const navigate = useNavigate();
  const { t, i18n } = useTranslation(); // Combined useTranslation hooks into one call

  useEffect(() => {
    const language = i18n.language; // Current language from i18n
    fetch(`http://localhost:/project/monisakor-primary-school/server/api/getAlbums.php?lang=${language}`) // Pass language in query
      .then((response) => response.json())
      .then((data) => setAlbums(data))
      .catch((error) => console.error("Error fetching albums:", error));
  }, [i18n.language]); // Re-fetch albums when language changes

  return (
    <div className="">
      <div className="container mx-auto py-12 mt-20">
        <h2 
         data-aos="fade-up"
        data-aos-duration="1000"
        className="text-center title-font text-3xl sm:text-4xl md:text-5xl mb-4 sm:mb-6 font-extrabold text-primary text-lang leading-tight transition-all duration-300 ease-in-out transform hover:scale-105 hover:text-secondary ">
          {t("gallery")}
        </h2>
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          {albums.map((album, index) => (
            <div key={index}
             data-aos="fade-up"
              data-aos-duration="1000" 
              className="p-4 border border-gray-300 rounded-lg ">
              <h3 className="text-xl font-semibold mb-2 text-primary">
                {album[`album_name_${i18n.language}`] || album.album_name} {/* Fetch album name based on language */}
              </h3>
              <button
                onClick={() => navigate(`/galleryphoto/${album.album_name}`)}
                className="mt-1 focus:outline-none cursor-pointer text-white bg-secondary hover:scale-105 transition duration-300 font-medium rounded-lg text-sm px-5 py-2.5"
              >
                {t("open")}
              </button>
            </div>
          ))}
        </div>
      </div>
    </div>
  );
};

export default Gallery;
