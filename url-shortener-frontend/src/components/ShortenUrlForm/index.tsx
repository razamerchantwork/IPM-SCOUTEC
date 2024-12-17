import React, { useState } from "react";
import { ArrowRightIcon } from "@heroicons/react/24/solid";
import { toast } from "react-toastify";
import { validateUrl } from "../../utils";
import { postShortenURL } from "../../api";
import { IShortenedUrl } from "../../interfaces";
import Input from "../UI/Input";

interface ShortenUrlFormProps {
  onUrlShortened: (newUrl: IShortenedUrl) => void;
}

const ShortenUrlForm: React.FC<ShortenUrlFormProps> = ({ onUrlShortened }) => {
  const [url, setUrl] = useState<string>("");
  const [isSubmitting, setIsSubmitting] = useState<boolean>(false);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setIsSubmitting(true);

    if (!url || !validateUrl(url)) {
      toast.error("Please enter a valid URL.");
      setIsSubmitting(false);
      return;
    }

    const response = await postShortenURL(url);
    setIsSubmitting(false);

    if (response) {
      onUrlShortened(response.newShortenUrl);
      setUrl("");
      toast.success(response.message);
    }
  };

  return (
    <form
      onSubmit={handleSubmit}
      className="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-4"
    >
      <Input
        type="text"
        value={url}
        onChange={setUrl}
        placeholder="Enter your URL"
        isValid={url === "" || validateUrl(url)}
        className="w-full sm:w-2/3"
      />
      <button
        type="submit"
        disabled={!validateUrl(url) || isSubmitting}
        className={`w-full sm:w-auto p-2 rounded-lg ${
          validateUrl(url)
            ? "bg-blue-500 text-white hover:bg-blue-600 focus:ring-2 focus:ring-blue-500"
            : "bg-gray-300 text-gray-500 cursor-not-allowed"
        }`}
      >
        <ArrowRightIcon className="w-6 h-6" />
      </button>
    </form>
  );
};

export default ShortenUrlForm;
