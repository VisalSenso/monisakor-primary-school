import React, { useEffect, useState } from "react";
import { FaPenFancy, FaBookOpen, FaPencilAlt } from 'react-icons/fa'; // Import icons from react-icons/fa

const Test = () => {

  return (
    <div className="relative w-full h-screen bg-gradient-to-r from-blue-100 to-blue-300 overflow-hidden">
    {/* Pen Icon */}
    <FaPenFancy className="absolute top-10 left-10 w-16 h-16 text-blue-600 opacity-70 animate-bounce" />

    {/* Book Icon */}
    <FaBookOpen className="absolute bottom-20 left-1/2 transform -translate-x-1/2 w-20 h-20 text-blue-800 opacity-80 animate-pulse" />

    {/* Pencil Icon */}
    <FaPencilAlt className="absolute top-20 right-10 w-14 h-14 text-blue-500 opacity-60 animate-spin-slow" />

    {/* Content */}
    <div className="flex flex-col items-center justify-center h-full text-center px-4">
      <h1 className="text-4xl md:text-6xl font-bold text-blue-900">Welcome to Our Education Site</h1>
      <p className="mt-4 text-lg md:text-2xl text-blue-800">Learn, Grow, and Achieve</p>
    </div>
  </div>
  );
};

export default Test;
