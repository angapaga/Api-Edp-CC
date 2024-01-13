import { Component, OnInit } from '@angular/core';
import { NavController } from '@ionic/angular';
import { menuItem } from '../../models/menuItem.model';
import { Router } from '@angular/router';
import { ToastController } from '@ionic/angular';
import { PostService } from '../../services/post.service';
import { Storage } from '@ionic/storage';

@Component({
  selector: 'app-edp-cc-calidadmateriaprima',
  templateUrl: './edp-cc-calidadmateriaprima.page.html',
  styleUrls: ['./edp-cc-calidadmateriaprima.page.scss'],
})
export class EdpCcCalidadmateriaprimaPage implements OnInit {

  //definicion de variables
  menuItems: menuItem[];

  constructor(private navCtrl: NavController,
              public toastController: ToastController,
              private postPvdr: PostService,
              private storage: Storage,
              private route: Router,){

    this.menuItems = [
      new menuItem('Panel de sabor','','','edp-cc-panelsabor'),
      new menuItem('Evaluación de cabezas cargadas','','','edp-cc-menucabezascargadas'),
      new menuItem('Evaluación de aspectos físicos','','','edp-cc-menuremuestrasfisicas'),
    ]

  }

ngOnInit() {
  this.storage.create();
  this.storage.get('session_storage').then((data)=>{
   if(data===null)
   this.route.navigate(['/edp-cc-login']);
  });
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
