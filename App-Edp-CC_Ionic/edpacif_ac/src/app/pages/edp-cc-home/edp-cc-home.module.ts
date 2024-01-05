import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { EdpCcHomePageRoutingModule } from './edp-cc-home-routing.module';

import { EdpCcHomePage } from './edp-cc-home.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    EdpCcHomePageRoutingModule
  ],
  declarations: [EdpCcHomePage]
})
export class EdpCcHomePageModule {}
