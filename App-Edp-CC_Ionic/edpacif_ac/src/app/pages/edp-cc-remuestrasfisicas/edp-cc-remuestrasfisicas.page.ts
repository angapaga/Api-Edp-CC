import { Component, OnInit } from '@angular/core';
import { NavController,
  AlertController,
  ToastController } from '@ionic/angular';

import { PostService } from "../../services/post.service"; 
import { Storage } from "@ionic/storage";     
import { Router } from "@angular/router"; 
import { DataService } from "../../services/data.service"; 

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
  periodo:any;
  defects:any;
  defecto:any;
  act_muestras:any = false;
  sesion:any;
  cedula:any;
  cod_usua:any;
  username:any;
  cod_asignacion:any;
  constructor(private navCtrl: NavController, 
              private toastController: ToastController,
              private alertController: AlertController,
              private postPvdr: PostService,
              private storage: Storage,
              private router: Router,
              private dataService: DataService) { }
  obtenerPeriodo() {
    this.periodo = this.dataService.getPeriodo();
    console.log('Valor de la variable:', this.periodo);
  }
  ngOnInit() { 
    this.storage.create();
    this.storage.get('session_storage').then((res) => {
      this.sesion = res; 
      this.storage.get('periodo').then((res) => {
        this.periodo = res; 
          this.storage.get('cabecera_fisica').then((res) => {
            this.cabecera = res; 
            this.mostrar_pe(this.cabecera);
            this.mostrar_detalles_pr(this.cabecera);
            this.get_defects();
          //console.log(this.cabecera);
          }); 

          this.cedula = this.sesion[0].usua_cod_empl;
          this.cod_usua = this.sesion[0].cod_usua;
          this.username = this.sesion[0].username;
          //console.log(this.username);
    });
  });
    

    
  }

  regresar() {
    // Utiliza el método pop() del NavController para regresar a la página anterior
    this.navCtrl.pop();
  }

  ionViewWillEnter() {
   
  }

  async presentConfirm() {
    let alert = await this.alertController.create({
      header: 'Advertencia',
      message: 'Esta seguro de procesar este documento, si lo procesa aya no podrá realizar cambios',
      buttons: [
        {
          text: 'No',
          role: 'cancel',
          handler: () => {
          }
        },
        {
          text: 'Si',
          handler: () => {
            this.process_doc();
          }
        }
      ]
    });
      await alert.present();
      
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
      cod_usua: this.cod_usua,
      cabecera: cabecera,
      periodo: this.periodo,
      empleado:this.cedula
    };
    //console.log(this.cedula);

    this.postPvdr.postData(body, 'Api-Edp-CC-Aseg-Calidad.php').subscribe(
      (data: any) => {

        //console.log(data.result[0]);
        this.contar=0;
        if (data.code == 200) {
          for (let get_lista of data.result) {
            this.lista_pe.push(get_lista);
            this.contar = this.contar +1;
            // console.log(this.lista_pe);
          }
          resolve(this.lista_pe);
          this.total = this.lista_pe.length;
          this.muestras =this.lista_pe[0].muestras;
          this.cod_asignacion = this.lista_pe[0].cod_asignacion;
          if (this.muestras>0){ 
            this.act_muestras = true;
          }else{this.act_muestras = false;}

        } else {
          this.toast_ok(data.message,'danger', 'middle')
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
      cod_usua: this.cod_usua,
      cabecera: cabecera,
      periodo: this.periodo,
    };

    this.postPvdr.postData(body, 'Api-Edp-CC-Aseg-Calidad.php').subscribe(
      (data: any) => {

        if (data.code == 200) {
          for (let get_listad of data.result) {
            this.lista_detalles_pr.push(get_listad);
          }
          resolve(this.lista_detalles_pr);
          console.log(this.lista_detalles_pr);
        } else {
          this.toast_ok(data.message,'danger', 'middle')
          //this.presentAlert('', data.result); // Puedes enviar el mensaje de error como argumento a reject
        }
      },
      (error) => {
        reject("Error en la solicitud HTTP"); // Manejo de errores de la solicitud HTTP
      }
    );
  });
}

get_defects() {
  return new Promise((resolve, reject) => {
    this.defects = null;
    this.defects = [];
    //console.log(this.periodo);
    let body = {
      peticion: "Defectos_Activos_Bajar_No_Deta",
      cabecera: this.cabecera,
      cod_usua: this.cod_usua,
      periodo: this.periodo,
    };

    //console.log(this.periodo);

    this.postPvdr.postData(body, 'Api-Edp-CC-Aseg-Calidad.php').subscribe(
      (data: any) => {

        if (data.code == 200) {
          for (let defect of data.result) {
            this.defects.push(defect);
          }
          resolve(this.defects);
        } else {
          //this.toast_ok(data.message,'danger', 'top')
          //this.presentAlert('', data.result); // Puedes enviar el mensaje de error como argumento a reject
        }
      },
      (error) => {
        reject("Error en la solicitud HTTP"); // Manejo de errores de la solicitud HTTP
      }
    );
  });
}

add_detalle()
{
  return new Promise((resolve, reject) => {
    this.defects = null;
    this.defects = [];
    //console.log(this.periodo);
    let body = {
      peticion: "Insertar_detalles_fisico",
      cabecera: this.cabecera,
      cod_usua: this.cod_usua,
      periodo: this.periodo,
      defecto: this.defecto,
      cantidad:this.cantidad,
      muestras: this.muestras
    };

    //console.log(this.muestras);

    this.postPvdr.postData(body, 'Api-Edp-CC-Aseg-Calidad.php').subscribe(
      (data: any) => {

        if (data.code == 200) {
          this.toast_ok(data.message,'success', 'top')
          this.update_muestras();  
        } else {
          this.toast_ok(data.message,'danger', 'top')
        }
        
        this.get_defects();
        this.mostrar_detalles_pr(this.cabecera);
        this.mostrar_pe(this.cabecera);
        this.defecto=null;
        this.cantidad= null;
      },
      (error) => {
        reject("Error en la solicitud HTTP"); // Manejo de errores de la solicitud HTTP
      }
    );
  });

}

update_muestras()
{
  return new Promise((resolve, reject) => {
    this.defects = null;
    this.defects = [];
    //console.log(this.periodo);
    let body = {
      peticion: "Actualiza_muestras_fisica",
      cabecera: this.cod_asignacion,
      cod_usua: this.cod_usua,
      periodo: this.periodo,
      muestras: this.muestras
    };

    this.postPvdr.postData(body, 'Api-Edp-CC-Aseg-Calidad.php').subscribe(
      (data: any) => {

        if (data.code == 200) {
          this.toast_ok(data.message,'success', 'top')
          
        } else {
          this.toast_ok(data.message,'danger', 'top')
        }
      },
      (error) => {
        reject("Error en la solicitud HTTP"); // Manejo de errores de la solicitud HTTP
      }
    );
  });

}

process_doc()
{
  return new Promise((resolve, reject) => {
    this.defects = null;
    this.defects = [];
    //console.log(this.periodo);
    let body = {
      peticion: "Procesa_muestras_fisica",
      cabecera: this.cabecera,
      cod_usua: this.cod_usua,
      periodo: this.periodo
    };

    this.postPvdr.postData(body, 'Api-Edp-CC-Aseg-Calidad.php').subscribe(
      (data: any) => {

        if (data.code == 200) {
          this.toast_ok(data.message,'success', 'top')
          this.router.navigate(['/edp-cc-remuestrafisicapendientes']); 
          
        } else {
          this.toast_ok(data.message,'danger', 'top')
        }
      },
      (error) => {
        reject("Error en la solicitud HTTP"); // Manejo de errores de la solicitud HTTP
      }
    );
  });

}

remove_detalle(detalle:any)
{
  return new Promise((resolve, reject) => {
    this.defects = null;
    this.defects = [];
    //console.log(this.periodo);
    let body = {
      peticion: "Anular_detalles_fisica",
      detalle: detalle,
      cod_usua: this.cod_usua,
      periodo: this.periodo
    };

    //console.log(this.muestras);

    this.postPvdr.postData(body, 'Api-Edp-CC-Aseg-Calidad.php').subscribe(
      (data: any) => {

        if (data.code == 200) {
          this.toast_ok(data.message,'success', 'top')
          this.mostrar_detalles_pr(this.cabecera);
        } else {
          this.toast_ok(data.message,'danger', 'top')
        }

      },
      (error) => {
        this.toast_ok("Error en la solicitud HTTP "+error.message,'danger', 'top'); // Manejo de errores de la solicitud HTTP
      }
    );
  });

}

}
