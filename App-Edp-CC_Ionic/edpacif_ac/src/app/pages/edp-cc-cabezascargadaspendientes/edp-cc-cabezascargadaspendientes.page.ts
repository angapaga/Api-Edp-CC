import { Component, OnInit } from '@angular/core';
import { NavController,
  AlertController,
  ToastController } from '@ionic/angular';

import { PostService } from "../../services/post.service"; 
import { Storage } from "@ionic/storage";     
import { Router } from "@angular/router"; 


@Component({
  selector: 'app-edp-cc-cabezascargadaspendientes',
  templateUrl: './edp-cc-cabezascargadaspendientes.page.html',
  styleUrls: ['./edp-cc-cabezascargadaspendientes.page.scss'],
})
export class EdpCcCabezascargadaspendientesPage implements OnInit {

  lista_pe:any;
  contar :any;
  total :any;

  constructor(private navCtrl: NavController, 
              private toastController: ToastController,
              private alertController: AlertController,
              private postPvdr: PostService,
              private storage: Storage,
              private router: Router) { }

  ngOnInit() { 
  }

  regresar() {
    // Utiliza el método pop() del NavController para regresar a la página anterior
    this.navCtrl.pop();
  }

  ionViewWillEnter() {
    this.mostrar_pe();
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


mostrar_pe() {
  return new Promise((resolve, reject) => {
    this.lista_pe = null;
    this.lista_pe = [];

    let body = {
      peticion: "cabecera_remuestra_fisico_estado",
      cod_usua: "45",
      estado: "PE",
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

editar_doc(cabecera:any){
  this.storage.set('cabecera', cabecera);
  this.router.navigate(['/editar-doc-rc']);
}

onButtonClick(item: any) {
  // Lógica para manejar el clic en el botón para el elemento específico.
  console.log('Botón clic en:', item);
}


}
