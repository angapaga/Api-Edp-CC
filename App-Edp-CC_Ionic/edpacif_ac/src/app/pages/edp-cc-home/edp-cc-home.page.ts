import { Component, OnInit } from '@angular/core';
import { menuItem } from '../../models/menuItem.model';
import { NavController } from '@ionic/angular';

import { Router } from '@angular/router';
import { ToastController } from '@ionic/angular';
import { PostService } from '../../services/post.service';
import { Storage } from '@ionic/storage';

@Component({
  selector: 'app-edp-cc-home',
  templateUrl: './edp-cc-home.page.html',
  styleUrls: ['./edp-cc-home.page.scss'],
})
export class EdpCcHomePage implements OnInit {

  //definicion de variables
  menuItems: menuItem[];

  constructor(private route: Router,
    public toastController: ToastController,
    private postPvdr: PostService,
    private storage: Storage,
    private navCtrl: NavController) {

    this.menuItems = [
      new menuItem('Calidad de Materia Prima','','','edp-cc-calidadmateriaprima'),
      new menuItem('Calidad de Producto en Proceso','','','calidadproductoproceso'),
      new menuItem('Calidad de Producto Terminado','','','calidadproductoterminado'),
    ]

  }

  ngOnInit() {
    this.storage.create();
     this.storage.get('session_storage').then((data)=>{
      if(data===null)
      this.route.navigate(['/edp-cc-login']);
     });
  }

  async logout() {
    this.storage.clear();
    this.route.navigate(['/edp-cc-login']);
    const toast = await this.toastController.create({
      message: 'Usted ha cerrado Sesión',
      duration: 2000,
      position: 'top',
      color: 'danger'
     });
    toast.present();
  }

}
