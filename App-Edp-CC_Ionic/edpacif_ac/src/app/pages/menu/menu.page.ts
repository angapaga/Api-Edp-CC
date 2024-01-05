import { Component, OnInit } from '@angular/core';
import { menuItem } from '../../models/menuItem.model'

@Component({
  selector: 'app-menu',
  templateUrl: './menu.page.html',
  styleUrls: ['./menu.page.scss'],
})
export class MenuPage implements OnInit {

  //definicion de variables
  menuItems: menuItem[];

  constructor() {

    this.menuItems = [
      new menuItem('Calidad de Materia Prima','','','calidadmateriaprima'),
      new menuItem('Calidad de Producto en Proceso','','','calidadproductoproceso'),
      new menuItem('Calidad de Producto Terminado','','','calidadproductoterminado'),
    ]

  }

  ngOnInit() {
  }

}
