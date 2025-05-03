import React, { useState } from "react";
import slide1 from "../assets/images/schoolImages/slide1.jpg";
import slide2 from "../assets/images/schoolImages/slide2.jpg";
import slide3 from "../assets/images/schoolImages/slide3.jpg";

const Carousel = () => {
  const [activeSlide, setActiveSlide] = useState(0); // Track the active slide
  const slides = [slide1, slide2, slide3];

  const nextSlide = () => {
    setActiveSlide((prev) => (prev + 1) % slides.length);
  };

  const prevSlide = () => {
    setActiveSlide((prev) => (prev - 1 + slides.length) % slides.length);
  };

  return (
    <div className="mx-aut0 bg-amber-200">
      {/* Carousel Section */}
      <div id="default-carousel" className="relative" data-carousel="static">
        <div className="overflow-hidden relative h-96 rounded-lg sm:h-64 xl:h-96 2xl:h-96">
          {slides.map((slide, index) => (
            <div
              key={index}
              className={`${
                index === activeSlide ? "block" : "hidden"
              } duration-700 ease-in-out`}
              data-carousel-item
            >
              <img
                src={slide}
                className="object-contain block"
                alt={`slide${index + 1}`}
              />
            </div>
          ))}
        </div>

        <div className="flex absolute bottom-5 left-1/2 z-30 space-x-3 -translate-x-1/2">
          {[0, 1, 2].map((index) => (
            <button
              key={index}
              type="button"
              className={`w-3 h-3 rounded-full ${
                index === activeSlide ? "bg-blue-500" : "bg-gray-300"
              }`}
              aria-current={index === activeSlide ? "true" : "false"}
              aria-label={`Slide ${index + 1}`}
              onClick={() => setActiveSlide(index)}
              data-carousel-slide-to={index}
            ></button>
          ))}
        </div>

        <button
          type="button"
          className="flex absolute top-0 left-0 z-30 justify-center items-center px-4 h-full cursor-pointer group focus:outline-none"
          onClick={prevSlide}
        >
          <span className="inline-flex justify-center items-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
            <svg
              className="w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-gray-800"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                strokeLinecap="round"
                strokeLinejoin="round"
                strokeWidth="2"
                d="M15 19l-7-7 7-7"
              ></path>
            </svg>
          </span>
        </button>

        <button
          type="button"
          className="flex absolute top-0 right-0 z-30 justify-center items-center px-4 h-full cursor-pointer group focus:outline-none"
          onClick={nextSlide}
        >
          <span className="inline-flex justify-center items-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
            <svg
              className="w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-gray-800"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                strokeLinecap="round"
                strokeLinejoin="round"
                strokeWidth="2"
                d="M9 5l7 7-7 7"
              ></path>
            </svg>
          </span>
        </button>
      </div>
    </div>
  );
};

export default Carousel;
