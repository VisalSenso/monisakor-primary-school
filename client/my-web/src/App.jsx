import React, { useEffect } from "react";
import { BrowserRouter as Router, Route, Routes } from "react-router-dom";
import Home from "./pages/Home.jsx";
import News from "./pages/News.jsx";
import AboutUs from "./pages/AboutUs.jsx";
import Extras from "./pages/Extras.jsx";
import ContactUs from "./pages/ContectUs.jsx";
import NewsDetail from "./pages/NewsDetail.jsx";
import Header from "./components/Header.jsx";
import Footer from "./components/Footer.jsx";
import Gallery from "./pages/Gallery.jsx";
import GalleryPhotos from "./pages/GalleryPhotos.jsx";
import Staff from "./pages/Staff.jsx";
import Join from "./pages/Join.jsx";
import Test from "./pages/Test.jsx";
import './i18n'; // Adjust the path based on your folder structure
import { useTranslation } from "react-i18next";

const App = () => {
  const { i18n } = useTranslation();

  useEffect(() => {
    document.body.className = i18n.language === "kh" ? "khmer-font" : "english-font";
  }, [i18n.language]);
  return (
    <Router>
      <div>
        <Header />
        <Routes>
          <Route path="/" element={<Home />} />
          <Route path="/news" element={<News />} />
          <Route path="/about" element={<AboutUs />} />
          <Route path="/extras" element={<Extras />} />
          <Route path="/contact" element={<ContactUs />} />
          <Route path="/newsdetail" element={<NewsDetail />} />
          <Route path="/gallery" element={<Gallery />} />
          <Route path="/galleryphoto/:albumName" element={<GalleryPhotos />} />
          <Route path="/staff" element={<Staff />} />
          <Route path="/join" element={<Join />} />
          <Route path="/test" element={<Test />} />
          {/* Add more routes as needed */}
        </Routes>
        <Footer />
      </div>
    </Router>
  );
};

export default App;
