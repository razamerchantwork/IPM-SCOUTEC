import React from "react";

interface InputProps {
  type: string;
  value: string;
  onChange: (value: string) => void;
  placeholder?: string;
  isValid?: boolean;
  className?: string;
}

const Input: React.FC<InputProps> = ({
  type,
  value,
  onChange,
  placeholder,
  isValid,
  className,
}) => {
  return (
    <input
      type={type}
      value={value}
      onChange={(e) => onChange(e.target.value)}
      placeholder={placeholder}
      className={`flex-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 ${
        isValid
          ? `border-gray-300 focus:ring-blue-500 ${className}`
          : `border-red-500 focus:ring-red-500 ${className}`
      }`}
    />
  );
};

export default Input;
