import { Component, OnInit } from '@angular/core';
import { NavController } from '@ionic/angular';
import { menuItem } from '../../models/menuItem.model';

@Component({
  selector: 'app-edp-cc-calidadmateriaprima',
  templateUrl: './edp-cc-calidadmateriaprima.page.html',
  styleUrls: ['./edp-cc-calidadmateriaprima.page.scss'],
})
export class EdpCcCalidadmateriaprimaPage implements OnInit {

  //definicion de variables
  menuItems: menuItem[];

  constructor(private navCtrl: NavController){

    this.menuItems = [
      new menuItem('Panel de sabor','','','edp-cc-panelsabor'),
      new menuItem('Evaluación de cabezas cargadas','','','calidadproductoproceso'),
      new menuItem('Evaluación de aspectos físicos','','','calidadproductoterminado'),
    ]

  }

ngOnInit() {
}

regresar() {
  // Utiliza el método pop() del NavController para regresar a la página anterior
  this.navCtrl.pop();
}

}
