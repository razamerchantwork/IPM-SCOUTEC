import React from "react";
import { Link } from "react-router-dom";

const Navbar: React.FC = () => {
  return (
    <header className="bg-[#C9C1FA] text-white py-3 shadow-md">
      <div>
        <h1 className="text-lg font-bold flex justify-center">
          <Link to="/">IPM Scoutek</Link>
        </h1>
      </div>
    </header>
  );
};
export default Navbar;
