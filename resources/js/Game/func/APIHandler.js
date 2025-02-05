export default class SocketHandler {

    constructor(scene){
        axios.request()
        this.matchmaking = window.Echo.channel('match_making').listen('MatchMakingEvent', (e) => {
            if(e.type == 'match_found'){
                scene.scene.start('GameScene', {socket: scene.socket, match: e.match});
            }
        });
    }

    static matchMakingRequest(socket){
        this.matchmaking.emit('match_making_request');
    }

    static matchMakingCancel(socket){
        this.matchmaking.emit('match_making_cancel');
    }


}
