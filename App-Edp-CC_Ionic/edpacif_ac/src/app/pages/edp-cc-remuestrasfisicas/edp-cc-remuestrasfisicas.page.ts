import { Component, OnInit } from '@angular/core';
import { NavController,
  AlertController,
  ToastController } from '@ionic/angular';

import { PostService } from "../../services/post.service"; 
import { Storage } from "@ionic/storage";     
import { Router } from "@angular/router"; 

@Component({
  selector: 'app-edp-cc-remuestrasfisicas',
  templateUrl: './edp-cc-remuestrasfisicas.page.html',
  styleUrls: ['./edp-cc-remuestrasfisicas.page.scss'],
})
export class EdpCcRemuestrasfisicasPage implements OnInit {
  lista_pe:any;
  contar :any;
  total :any;
  cabecera :any;
  lista_detalles_pr:any;
  muestras:any;
  cantidad:any;

  constructor(private navCtrl: NavController, 
              private toastController: ToastController,
              private alertController: AlertController,
              private postPvdr: PostService,
              private storage: Storage,
              private router: Router) { }

  ngOnInit() { 
    this.storage.create();
    this.storage.get('cabecera_fisica').then((res) => {
      this.cabecera = res; 
      this.mostrar_pe(this.cabecera);
      this.mostrar_detalles_pr(this.cabecera);
     //console.log(this.cabecera);
    });
  }

  regresar() {
    // Utiliza el método pop() del NavController para regresar a la página anterior
    this.navCtrl.pop();
  }

  ionViewWillEnter() {
   
  }

  async toast_ok(msg:any,color:any, position:any){
  
    const toast = await this.toastController.create({
    message: msg,
    duration: 3000,
    color : color,
    position: position
  });
    toast.present();
}

async presentAlert(header:string, msg:string) {

  const alert = await this.alertController.create({
    cssClass: 'msg',
    header: header,
    message: msg,
    buttons: ['OK']
  });

  await alert.present();
  
}


mostrar_pe(cabecera:any) {
  return new Promise((resolve, reject) => {
    this.lista_pe = null;
    this.lista_pe = [];

    let body = {
      peticion: "cabecera_remuestra_fisico_cabecera",
      cod_usua: "45",
      cabecera: cabecera,
      periodo: "01",
      empleado:"1312992165"
    };

    this.postPvdr.postData(body, 'Api-Edp-CC-Aseg-Calidad.php').subscribe(
      (data: any) => {

        //console.log(data.result[0]);
        this.contar=0;
        if (data.code == 200) {
          for (let get_lista of data.result) {
            this.lista_pe.push(get_lista);
            this.contar = this.contar +1;
            //console.log(this.lista_pe);
          }
          resolve(this.lista_pe);
          this.total = this.lista_pe.length;
        } else {
          this.toast_ok(data.result,'danger', 'middle')
          //this.presentAlert('', data.result); // Puedes enviar el mensaje de error como argumento a reject
        }
      },
      (error) => {
        reject("Error en la solicitud HTTP"); // Manejo de errores de la solicitud HTTP
      }
    );
  });
}

mostrar_detalles_pr(cabecera:any) {
  return new Promise((resolve, reject) => {
    this.lista_detalles_pr = null;
    this.lista_detalles_pr = [];

    let body = {
      peticion: "detalles_remuestra_fisico_cabecera",
      cod_usua: "45",
      cabecera: cabecera,
      periodo: "01",
    };

    this.postPvdr.postData(body, 'Api-Edp-CC-Aseg-Calidad.php').subscribe(
      (data: any) => {

        if (data.code == 200) {
          for (let get_listad of data.result) {
            this.lista_detalles_pr.push(get_listad);
          }
          resolve(this.lista_detalles_pr);
          //console.log(this.lista_detalles_pr);
        } else {
          this.toast_ok(data.result,'danger', 'middle')
          //this.presentAlert('', data.result); // Puedes enviar el mensaje de error como argumento a reject
        }
      },
      (error) => {
        reject("Error en la solicitud HTTP"); // Manejo de errores de la solicitud HTTP
      }
    );
  });
}

}
