// import GameHandler from "../helpers/GameHandler"
// import DeckHandler from "../helpers/DeckHandler"
// import InteractiveHandler from "../helpers/InteractiveHandler"
// import UIHandler from "../helpers/UIHandler"
import SocketHandler from "../func/SocketHandler"
export default class Game extends Phaser.Scene{

    constructor(){
        super({
            key: 'Game'
        })

    }
    aggregate(data){
        this.deck=data
        console.log(this.deck)

    }
    preload(){}
    create(){

        this.SocketHandler = new SocketHandler(this);
        this.DeckHandler = new DeckHandler(this)
        this.GameHandler = new GameHandler(this)
        this.UIHandler = new UIHandler(this);
    }
    update() {

    }

}
