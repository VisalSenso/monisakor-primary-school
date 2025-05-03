import React, { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import { Link } from "react-router-dom";
import { IoCaretBackOutline } from "react-icons/io5";
import { useTranslation } from "react-i18next";

const GalleryPhotos = () => {
  const { albumName } = useParams();
  const [photos, setPhotos] = useState([]);
  const { t, i18n } = useTranslation();
  const [selectedImage, setSelectedImage] = useState(null);

  useEffect(() => {
    const lang = i18n.language;

    fetch(`http://localhost/project/monisakor-primary-school/server/api/getPhotos.php?album=${albumName}&lang=${lang}`)

      .then((response) => response.json())
      .then((data) => setPhotos(data))
      .catch((error) => console.error("Error fetching photos:", error));
  }, [albumName, i18n.language]);  // Ensure the effect runs when language changes

  return (
    <div className=" mt-20">
      <div className="container m-auto p-5">
        <Link
          to="/gallery"
          className="">
          <button className="flex rounded-full cursor-pointer items-center ju  h-10 w-24 pl-1 bg-primary hover:scale-105 transition duration-300 text-xl text-white"><IoCaretBackOutline />back</button>
        </Link>
      </div>

      <div className="container mx-auto py-12 m">
        <h2 className="text-center title-font text-3xl sm:text-4xl md:text-5xl mb-4 sm:mb-6 font-extrabold text-primary text-lang leading-tight transition-all duration-300 ease-in-out transform group-hover:scale-105 group-hover:text-secondary">
          {albumName}
        </h2>
        <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-4">
          {photos.length > 0 ? (
            photos.map((photo, index) => (
              <div key={index} className="group cursor-pointer relative">
                <img
                  src={
                    photo.image_url
                      ? `http://localhost/project/monisakor-primary-school/assects/images/gallery/${photo.image_url.replace(/^.*[\\\/]/, ""
                      )}`
                      : "https://via.placeholder.com/150"
                  }
                  alt={`Image ${index + 1}`}
                  className="w-full h-48 object-cover rounded-lg transition-transform transform scale-100 group-hover:scale-105"
                />
                <div className="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                  <button
                    onClick={() =>
                      window.open(
                        `http://localhost/project/monisakor-primary-school/assects/images/gallery/${photo.image_url.replace(/^.*[\\\/]/, "")}`,
                        "_blank"
                      )
                    }
                    className="bg-blue-500 hover:bg-blue-700 text-white font-bold rounded-full px-4 py-2"
                  >
                    {t("veiw")}
                  </button>

                </div>
              </div>
            ))
          ) : (
            <p className="text-center w-full">No images available.</p>
          )}
        </div>
      </div>
      {selectedImage && (
        <div
          className="fixed inset-0 bg-black/80 backdrop-blur-sm flex items-center justify-center z-50"
          onClick={() => setSelectedImage(null)}
        >
          <img
            src={selectedImage}
            alt="Enlarged"
            className="max-w-[90%] max-h-[90%] rounded-lg shadow-lg"
            onClick={(e) => e.stopPropagation()}
          />
          <button
            className="absolute top-4 right-4 text-white text-3xl font-bold"
            onClick={() => setSelectedImage(null)}
          >
            &times;
          </button>
        </div>
      )}

    </div>
  );
};

export default GalleryPhotos;
