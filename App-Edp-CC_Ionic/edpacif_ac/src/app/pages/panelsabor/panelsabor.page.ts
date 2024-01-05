import { Component, OnInit } from '@angular/core';
import { NavController } from '@ionic/angular';

@Component({
  selector: 'app-panelsabor',
  templateUrl: './panelsabor.page.html',
  styleUrls: ['./panelsabor.page.scss'],
})
export class PanelsaborPage implements OnInit {

  constructor(private navCtrl: NavController) { }

  ngOnInit() {
  }

  regresar() {
    // Utiliza el método pop() del NavController para regresar a la página anterior
    this.navCtrl.pop();
  }

}
