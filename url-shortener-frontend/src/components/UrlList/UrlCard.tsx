import React from "react";
import { IShortenedUrl } from "../../interfaces";

interface IUrlCard {
  shortenedUrl: IShortenedUrl;
}

const UrlCard: React.FC<IUrlCard> = ({ shortenedUrl }) => {
  return (
    <li className="p-3 lg:p-4 bg-white min-w-max gap-4  border rounded-lg flex justify-between items-center shadow-lg">
      <div className="flex items-center space-x-2 md:space-x-4 rounded-full">
        <div className="flex flex-col">
          <a
            href={shortenedUrl.short_url}
            target="_blank"
            className="text-black font-bold text-sm md:text-lg hover:underline break-words"
          >
            {shortenedUrl.short_url}
          </a>
          <a
            href={`${shortenedUrl.original_url}`}
            title={`${shortenedUrl.original_url}`}
            target="_blank"
            className="text-gray-500 text-sm md:text-lg hover:underline break-words"
          >
            {shortenedUrl.original_url}
          </a>
          <i className="">{shortenedUrl.expires_in}</i>
        </div>
      </div>
      <div className="flex items-center space-x-4">
        <div className="flex flex-col items-end">
          <button className="text-gray-600 bg-gray-200 py-1 px-2 md:px-4 rounded-lg border border-gray-400 font-normal text-sm">
            {`${shortenedUrl.click_count} ${
              shortenedUrl.click_count === 1 ? "Click" : "Clicks"
            }`}
          </button>
        </div>
      </div>
    </li>
  );
};
export default UrlCard;
