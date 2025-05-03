
import React, { useState, useEffect, useCallback } from "react";
import AOS from "aos";
import "aos/dist/aos.css";
import { useTranslation } from "react-i18next";
import DarkMode from "./DarkMode.jsx";
import LanguageSwitcher from "./LanguageSwitcher.jsx";
import { Link } from "react-router-dom";
import Nav from "./Nav.jsx";

const Header = () => {
  const [isMenuOpen, setIsMenuOpen] = useState(false);
  const [isDarkMode, setIsDarkMode] = useState(
    localStorage.getItem("theme") === "dark"
  );
  const [language, setLanguage] = useState(
    localStorage.getItem("language") || "kh"
  );
  const [isVisible, setIsVisible] = useState(true);
  const { t } = useTranslation();

  useEffect(() => {
    if (typeof window !== "undefined") {
      AOS.init({ duration: 1000 });
    }
  }, []);

  useEffect(() => {
    let lastScrollY = window.scrollY;

    const handleScroll = () => {
      if (window.scrollY > lastScrollY) {
        setIsVisible(false);
      } else {
        setIsVisible(true);
      }
      lastScrollY = window.scrollY;
    };

    window.addEventListener("scroll", handleScroll);

    return () => {
      window.removeEventListener("scroll", handleScroll);
    };
  }, []);

  const toggleMenu = useCallback(() => {
    setIsMenuOpen((prev) => !prev);
  }, []);

  const toggleDarkMode = useCallback(() => {
    setIsDarkMode(!isDarkMode);
    localStorage.setItem("theme", !isDarkMode ? "dark" : "light");
  }, [isDarkMode]);

  const switchLanguage = useCallback((newLang) => {
    setLanguage(newLang);
    localStorage.setItem("language", newLang);
  }, []);

  return (
    <header
      id="header"
      className={`bg-white dark:bg-backgroun-dark shadow-lg body-font sticky top-0 z-50 opacity-100 transition-all sm:p-6 flex items-center justify-between h-24 ${
        isVisible ? "translate-y-0" : "-translate-y-full"
      }`}
    >
      <div className="container mx-auto flex items-center justify-between">
        {/* Logo */}
        <Link to="/" className="flex items-center text-gray-900">
          <img
            style={{ cursor: "pointer" }}
            className="w-20 h-20 bg-black-500 rounded-full"
            src="assets/images/defaults/logo.jpg"
            alt="logo"
          />
          <span
            className="ml-3 text-xl hidden sm:inline text-primary font-extrabold leng-text"
            data-i18n="school_title"
          >
            {t("school_title")}
          </span>
        </Link>

        {/* Right-side icons */}
        <div className="flex items-center justify-end space-x-4">
          {/* Mobile menu button */}
          <button
            id="menuIcon"
            className="lg:hidden text-gray-600 dark:text-gray-300"
            onClick={toggleMenu}
          >
            {isMenuOpen ? (
              <svg
                className="w-6 h-6"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  strokeLinecap="round"
                  strokeLinejoin="round"
                  strokeWidth={2}
                  d="M6 18L18 6M6 6l12 12"
                />
              </svg>
            ) : (
              <svg
                className="w-6 h-6"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  strokeLinecap="round"
                  strokeLinejoin="round"
                  strokeWidth={2}
                  d="M4 6h16M4 12h16m-7 6h7"
                />
              </svg>
            )}
          </button>

          {/* Dark mode toggle */}
          <DarkMode toggleDarkMode={toggleDarkMode} isDarkMode={isDarkMode} />
          {/* Language switcher */}
          <LanguageSwitcher switchLanguage={switchLanguage} language={language} />

          {/* Join Us button */}
          <button
            onClick={() => window.location.replace("joinus.php")}
            className=" lg:inline-flex items-center border-0 py-2 px-5 focus:outline-none rounded-full bg-primary text-white focus:ring-2 hover:scale-105 transition duration-300"
          >
            {t("joinus")}
          </button>
        </div>
      </div>

      {/* Mobile Navigation - Inside Header */}
      <div
        className={`lg:hidden transition-all duration-300 ease-in-out overflow-hidden 
        ${isMenuOpen ? "max-h-96 opacity-100" : "max-h-0 opacity-0"}`}
      >
        <nav className="flex flex-col items-center py-4 space-y-4">
          <Nav />
        </nav>
      </div>

      {/* Desktop Navigation */}
      <div className="hidden lg:block">
        <Nav />
      </div>
    </header>
  );
};

export default Header;
