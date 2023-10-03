export const useApiCustomer = (path, options = {}) => {
  let headers = {
    accept: "application/json",
    referer: "http://localhost:3000"
  };

  const token = useCookie('XSRF-TOKEN');

  if (token.value) {
    headers['X-XSRF-TOKEN'] = token.value
  }

  if (process.server) {
    headers = {
      ...headers,
      ...useRequestHeaders(["cookie"])
    }
  }

  return useFetch('http://localhost:8000/api/customer' + path, {
    credentials: 'include',
    watch: false,
    ...options,
    headers: {
      ...headers,
      ...options?.headers
    }
  });
}
