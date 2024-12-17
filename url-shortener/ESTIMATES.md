# Estimation of Tasks (Expected vs Actual)
### Task 1. Project Setup,structing and Package Installations

-   Expected Time: 10-15 mins
-   Actual Time: 09 mins

---

## Task 2: **Create Shortened URL**
**Description**: Implement functionality to generate a shortened URL by creating a unique short ID, storing the original URL in Redis with an expiration time, and initializing the click count.

## Task 2.1: **Find Original URL from Short ID**
**Description**: Retrieve the original URL from Redis using the short ID.

## Task 2.2: **Get Human-Readable TTL**
**Description**: Fetch the time-to-live (TTL) for the shortened URL and return it in a human-readable format (e.g., "5 minutes from now").

## Task 2.3: **Get Click Count**
**Description**: Retrieve the current click count for the shortened URL.

### Estimate:
- **Estimated Time**: 30 - 40 minutes
- **Tasks**:
  - Generate a unique short ID (hashing URL + timestamp).
  - Store the URL and expiration time in Redis.
  - Initialize the click count in Redis.
  - Return the short ID, original URL, expiration time, and click count.

### Actual Time:
- **Actual Time**: 60 minutes
- **Reason for Deviation**: Encountered minor issues with Redis key management and debugging the response format.

---
## Task 3: **Increment Click Count and Redirect to original url and error handling**
**Description**: Increment the click count for the shortened URL each time it is accessed.and when user copy the url and paste it to browser it should redirect user to orginal url if url expired or not found show the error page 

### Estimate:
- **Estimated Time**: 40 minutes
- **Tasks**:
  - Fetch and increment the click count in Redis for the short ID.
  - Return the updated click count.

### Actual Time:
- **Actual Time**: 30 minutes
- **Reason for Deviation**: Completed faster due to efficient Redis command usage.

---
## Task 4: **Fetch All Shortened URLs**
**Description**: Fetch all shortened URLs from Redis, along with their click count and expiration details.

### Estimate:
- **Estimated Time**: 40 minutes
- **Tasks**:
  - Retrieve all Redis keys associated with short URLs.
  - Fetch details such as short ID, original URL, click count, and expiration time for each URL.
  - Return the results in a structured format (array or collection).

### Actual Time:
- **Actual Time**: 50 minutes
- **Reason for Deviation**: Encountered some Redis key naming issues and additional debugging for handling empty collections.

---
