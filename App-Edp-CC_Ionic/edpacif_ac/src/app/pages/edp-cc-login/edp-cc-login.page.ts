import { Component, OnInit } from '@angular/core';
import { NavController } from '@ionic/angular';

@Component({
  selector: 'app-edp-cc-login',
  templateUrl: './edp-cc-login.page.html',
  styleUrls: ['./edp-cc-login.page.scss'],
})
export class EdpCcLoginPage implements OnInit {

  constructor(private navCtrl: NavController) {}

  ngOnInit() {
    
  }

  login(){
    this.navCtrl.navigateForward('/edp-cc-home');
  }

}
