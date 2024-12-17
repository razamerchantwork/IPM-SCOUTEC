import React, { useState, useEffect } from "react";
import { toast } from "react-toastify";
import { fetchShortenedUrls } from "../api";
import ShortenUrlForm from "../components/ShortenUrlForm";
import UrlList from "../components/UrlList";
import { IShortenedUrl } from "../interfaces";

const Dashboard: React.FC = () => {
  const [shortenedUrls, setShortenedUrls] = useState<IShortenedUrl[]>([]);

  useEffect(() => {
    getShortenedUrls();
  }, []);

  const getShortenedUrls = async () => {
    const response = await fetchShortenedUrls();
    if (response.error) {
      toast.error(response.message);
    } else {
      setShortenedUrls(response.shortenedUrls);
    }
  };

  const handleUrlShortened = (newShortenedUrl: IShortenedUrl) => {
    setShortenedUrls([...shortenedUrls, newShortenedUrl]);
  };

  return (
    <div className="flex items-center justify-center h-[90vh] bg-gray-100 px-4 md:px-6 lg:px-8">
      <div className="w-full max-w-2xl p-3 md:p-4 lg:p-6 bg-white rounded-lg h-[70%] overflow-auto md:overflow-hidden shadow-md">
        <h1 className="text-2xl font-bold text-center mb-6">
          Shorten Your URL
        </h1>
        <ShortenUrlForm onUrlShortened={handleUrlShortened} />

        <h2 className="text-lg font-semibold pt-1">Your Shortened URLs</h2>
        <UrlList shortenedUrls={shortenedUrls} />
      </div>
    </div>
  );
};

export default Dashboard;
