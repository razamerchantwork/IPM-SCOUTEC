export enum API_ROUTES {
    POST_SHORTEN_URL = "/shorten-url",
    GET_SHORTENED_URLS = "/shortened-urls",
  }
  
  export enum HTTP_STATUS_CODES {
    OK = 200,
    CREATED = 201,
    UNAUTHORIZED = 401,
    NOT_FOUND = 404,
    INTERNAL_SERVER_ERROR = 500,
  }
  