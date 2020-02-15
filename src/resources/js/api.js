export default {
    /*
     * @param path ex: `/events`
     */
    post(path, data) {
        return this.request(path, 'POST', data)
    },
    get(path, data) {
        return this.request(path, 'GET', data)
    },
    put(path, data) {
        return this.request(path, 'PUT', data)
    },
    request(path, method, data) {
        const headers = {}
        const accessToken = localStorage.getItem('accessToken')
        if(accessToken) {
            headers['Authorization'] = `Bearer ${accessToken}`
        }

        const version = 'v1'
        const apiUrl = `/api/${version}`
        const url = `${apiUrl}${path}`

        const opts = {
            url,
            method,
            data,
            headers,
        }

        return new Promise(async (resolve, reject) => {
            try {
                const { data } = await axios(opts)
                resolve(data)
            } catch(e) {
                reject(e.response.data)
                return
            }
        })
  }
}
