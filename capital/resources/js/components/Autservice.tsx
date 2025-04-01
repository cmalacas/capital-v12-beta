import Axios from 'axios';

class Authservice {

  async posts( url, data = [] ) {

    try {

        const response = await Axios.post(url, data)

        return response.data

    } catch ( error ) {

       return false;

    }

  }

}

export default new Authservice();