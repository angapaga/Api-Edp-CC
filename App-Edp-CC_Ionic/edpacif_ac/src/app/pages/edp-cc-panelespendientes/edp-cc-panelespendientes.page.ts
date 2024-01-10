import { Component, OnInit } from '@angular/core';
import { NavController } from '@ionic/angular';

@Component({
  selector: 'app-edp-cc-panelespendientes',
  templateUrl: './edp-cc-panelespendientes.page.html',
  styleUrls: ['./edp-cc-panelespendientes.page.scss'],
})
export class EdpCcPanelespendientesPage implements OnInit {

  constructor(private navCtrl: NavController) { }

  ngOnInit() {
  }

  regresar() {
    // Utiliza el método pop() del NavController para regresar a la página anterior
    this.navCtrl.pop();
  }

}
