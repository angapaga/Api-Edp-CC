import { Component, OnInit } from '@angular/core';
import { NavController } from '@ionic/angular';
import { menuItem } from '../../models/menuItem.model';

@Component({
  selector: 'app-edp-cc-panelsabor',
  templateUrl: './edp-cc-panelsabor.page.html',
  styleUrls: ['./edp-cc-panelsabor.page.scss'],
})
export class EdpCcPanelsaborPage implements OnInit {

  //definicion de variables
  menuItems: menuItem[];
  constructor(private navCtrl: NavController) { 

    this.menuItems = [
      // new menuItem('Calidad de Materia Prima','','','calidadmateriaprima'),
      new menuItem('Consolidar Paneles','','','edp-cc-consolidadpaneles'),
      new menuItem('Consulta de Paneles Pendientes','','','edp-cc-panelespendientes'),
    ]

  }

  ngOnInit() {
  }

  regresar() {
    // Utiliza el método pop() del NavController para regresar a la página anterior
    this.navCtrl.pop();
  }

}
