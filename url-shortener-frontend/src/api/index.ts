import axios from "axios";
import { API_ROUTES, HTTP_STATUS_CODES } from "../utils/enums";

// Axios instance with base URL and environment variables
const API = axios.create({
  baseURL: import.meta.env.VITE_API_BASE_URL,
});

export const postShortenURL = async (url: string) => {
  try {
    const response = await API.post(API_ROUTES.POST_SHORTEN_URL, { url });
    if (
      response.data.data &&
      response.data.status_code === HTTP_STATUS_CODES.OK
    ) {
      const data = response.data.data;
      const successMessage = response.data.message;
      return {
        newShortenUrl: data,
        error: false,
        message: successMessage,
      };
    } else {
      throw new Error(response.data.message);
    }
  } catch (error: unknown) {
    let errorMessage = "An unknown error occurred";
    if (error instanceof Error) {
      errorMessage = error.message;
    }
    return {
      data: null,
      error: true,
      message: errorMessage,
    };
  }
};

export const fetchShortenedUrls = async () => {
  try {
    const response = await API.get(API_ROUTES.GET_SHORTENED_URLS);
    if (
      response.data.data &&
      Array.isArray(response.data.data) &&
      response.data.status_code === HTTP_STATUS_CODES.OK
    ) {
      const data = response.data.data;
      return {
        shortenedUrls: data,
        error: false,
      };
    } else {
      throw new Error(response.data.message);
    }
  } catch (error: unknown) {
    let errorMessage = "An unknown error occurred";
    if (error instanceof Error) {
      errorMessage = error.message;
    }
    return {
      data: null,
      error: true,
      message: errorMessage,
    };
  }
};
