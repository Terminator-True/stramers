// import GameHandler from "../helpers/GameHandler"
// import DeckHandler from "../helpers/DeckHandler"
// import InteractiveHandler from "../helpers/InteractiveHandler"
// import UIHandler from "../helpers/UIHandler"
import SocketHandler from "../func/SocketHandler"
var path = require('path');
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
        // this.matter.world.setBounds().disableGravity();
        // this.circ = this.matter.add.image(200, 50, 'mana');

        // // Le asignamos un cuerpo con un radio de 180 px
        // this.circ.setBody({
        //     type: 'circle',
        //     radius: 180,
        // });

        // //Le asignamos velocidad, rebote y quitamos toda fricción

        // this.circ.setVelocity(6, 3);
        // this.circ.setAngularVelocity(0.01);
        // this.circ.setBounce(1);
        // this.circ.setFriction(0, 0, 0);

        // var width = this.cameras.main.width;
        // var height = this.cameras.main.height;

        // this.buscant = this.add.bitmapText(width/2-250,height/2-50,"text","Buscando Partida...").setFontSize(24);
        // this.InfoText = this.add.bitmapText(width/2-350,height/2-50,"text","").setFontSize(64)
        // this.InfoText.setDepth(1)

        this.DeckHandler = new DeckHandler(this)
        this.GameHandler = new GameHandler(this)
        this.SocketHandler = new SocketHandler(this);
        this.UIHandler = new UIHandler(this);
    }
    update() {

    }

}
