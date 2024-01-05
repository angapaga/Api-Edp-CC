import { Component, OnInit } from '@angular/core';
import { menuItem } from '../../models/menuItem.model';

@Component({
  selector: 'app-edp-cc-home',
  templateUrl: './edp-cc-home.page.html',
  styleUrls: ['./edp-cc-home.page.scss'],
})
export class EdpCcHomePage implements OnInit {

  //definicion de variables
  menuItems: menuItem[];

  constructor() {

    this.menuItems = [
      new menuItem('Calidad de Materia Prima','','','edp-cc-calidadmateriaprima'),
      new menuItem('Calidad de Producto en Proceso','','','calidadproductoproceso'),
      new menuItem('Calidad de Producto Terminado','','','calidadproductoterminado'),
    ]

  }

  ngOnInit() {
  }

}
