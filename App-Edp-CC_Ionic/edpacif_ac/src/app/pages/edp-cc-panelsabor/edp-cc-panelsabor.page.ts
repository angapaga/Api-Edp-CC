import { Component, OnInit } from '@angular/core';
import { NavController } from '@ionic/angular';
import { menuItem } from '../../models/menuItem.model';
import { Router } from '@angular/router';
import { ToastController } from '@ionic/angular';
import { PostService } from '../../services/post.service';
import { Storage } from '@ionic/storage';


@Component({
  selector: 'app-edp-cc-panelsabor',
  templateUrl: './edp-cc-panelsabor.page.html',
  styleUrls: ['./edp-cc-panelsabor.page.scss'],
})
export class EdpCcPanelsaborPage implements OnInit {

  //definicion de variables
  menuItems: menuItem[];
  constructor(private navCtrl: NavController,
    private route: Router,
    public toastController: ToastController,
    private postPvdr: PostService,
    private storage: Storage,) { 

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
