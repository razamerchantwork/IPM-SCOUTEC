// Validate if the URL is valid
export const validateUrl = (value: string): boolean => {
    const urlRegex = /^(https?:\/\/)?([\w-]+(\.[\w-]+)+)(\/[\w-]*)*$/i;
    return urlRegex.test(value);
  };
  