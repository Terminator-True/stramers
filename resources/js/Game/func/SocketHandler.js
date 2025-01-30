import axios from "axios"

export default class SocketHandler {

    constructor(scene){
        axios.get('/api/user')
        window.Echo.presenceChannel('game')
    }

}
