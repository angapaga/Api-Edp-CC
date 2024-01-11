import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { EdpCcLoginPageRoutingModule } from './edp-cc-login-routing.module';

import { EdpCcLoginPage } from './edp-cc-login.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    EdpCcLoginPageRoutingModule
  ],
  declarations: [EdpCcLoginPage]
})
export class EdpCcLoginPageModule {}
