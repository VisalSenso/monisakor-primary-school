import React, { useState, useEffect, useRef } from "react";
import "aos/dist/aos.css";
import AOS from "aos";
import { Link, useLocation } from "react-router-dom";
import { FaImages, FaCalendarAlt, FaUsers, FaClock } from "react-icons/fa";
import moeys from "../assets/images/schoolImages/moeyes.png";
import { useTranslation } from "react-i18next";
import BackgroundIcons from "../components/BackgroundIcons";

const Extras = () => {
  const { t } = useTranslation();
  useEffect(() => {
    AOS.init({ duration: 1000 });
  }, []);

  const sections = [
    {
      title: t("gallery"),
      icon: <FaImages />,
      link: "/gallery",
      description: t("gallery_desc"),
    },
    {
      title: t("class_routine"),
      icon: <FaClock />,
      link: "/class-routine",
      description: t("class_routine_desc"),
    },
    {
      title: t("calender"),
      icon: <FaCalendarAlt />,
      link: "/calendar",
      description: t("calender_desc"),
    },
    {
      title: t("staffs"),
      icon: <FaUsers />,
      link: "/staff",
      description: t("staffs_desc"),
    },
    {
      title: t("moeys"),
      icon: (
        <img src={moeys} alt="MOEYS Logo" className="w-10 h-10 object-cover" />
      ),
      link: "https://www.moeys.gov.kh/",
      external: true,
      description: t("moeys_desc"),
    },
  ];
  const extraRef = useRef(null);
  const location = useLocation();

  useEffect(() => {
    if (location.hash === "#extras" && extraRef.current) {
      extraRef.current.scrollIntoView({ behavior: "smooth" });
    }
  }, [location]);


  return (
    <div className="relative">
      <BackgroundIcons />
      <div className="mx-auto px-4 py-12 mt-20">
        <div ref={extraRef} className="w-1/2 m-auto">
          <h2 className="text-center title-font sm:text-5xl text-4xl mb-6 font-extrabold text-primary text-lang leading-tight transition-all duration-300 ease-in-out transform hover:scale-105 hover:text-secondary dark:hover:text-slate-200">
            {t("extra_title")}
          </h2>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          {sections.map((section, index) =>
            section.external ? (
              <a
                key={index}
                href={section.link}
                target="_blank"
                rel="noopener noreferrer"
                data-aos="fade-up"
                className="shadow-lg rounded-lg p-6 text-center hover:shadow-xl transition duration-300 flex justify-center items-center md:h-40 bg-card-light dark:bg-card-dark"
              >
                <div className="flex flex-col items-center">
                  <div className="text-4xl text-secondary">{section.icon}</div>
                  <h3 className="text-xl font-semibold mb-2">{section.title}</h3>
                  <p className="text-gray-700 dark:text-gray-200 text-sm text-center">
                    {section.description}
                  </p>
                </div>
              </a>
            ) : (
              <Link key={index} to={section.link}>
                <div
                  data-aos="fade-up"
                  className="shadow-lg rounded-lg p-6 text-center hover:shadow-xl transition duration-300 flex flex-col justify-center items-center md:h-40 bg-card-light   dark:bg-card-dark"
                >
                  <div className="text-4xl text-secondary">{section.icon}</div>
                  <h3 className="text-xl font-semibold mb-2">{section.title}</h3>
                  <p className="text-gray-700 dark:text-gray-200 text-sm text-center">
                    {section.description}
                  </p>
                </div>
              </Link>
            )
          )}
        </div>
      </div>
    </div>
  );
};

export default Extras;
