import React from "react";
import { IShortenedUrl } from "../../interfaces";
import UrlCard from "./UrlCard";

interface IUrlList {
  shortenedUrls: IShortenedUrl[];
}

const UrlList: React.FC<IUrlList> = ({ shortenedUrls }) => {
  return (
    <div className="mt-2 h-[60%] overflow-y-scroll">
      {shortenedUrls.length > 0 ? (
        <>
          <ul className="space-y-2">
            {shortenedUrls.map((shortenUrl) => (
              <UrlCard shortenedUrl={shortenUrl} key={shortenUrl.short_id} />
            ))}
          </ul>
        </>
      ) : (
        <p className="text-gray-500">No URLs shortened yet.</p>
      )}
    </div>
  );
};

export default UrlList;
