import { Component, OnInit } from '@angular/core';
import { NavController } from '@ionic/angular';
import { menuItem } from '../../models/menuItem.model';

@Component({
  selector: 'app-panelsabor',
  templateUrl: './panelsabor.page.html',
  styleUrls: ['./panelsabor.page.scss'],
})
export class PanelsaborPage implements OnInit {
  
  //definicion de variables
  menuItems: menuItem[];
  constructor(private navCtrl: NavController) { 

    this.menuItems = [
      // new menuItem('Calidad de Materia Prima','','','calidadmateriaprima'),
      new menuItem('Consolidar Paneles','','','consolidadpaneles'),
      new menuItem('Consulta de Paneles Pendientes','','','panelespendientes'),
    ]

  }

  ngOnInit() {
  }

  regresar() {
    // Utiliza el método pop() del NavController para regresar a la página anterior
    this.navCtrl.pop();
  }

}
