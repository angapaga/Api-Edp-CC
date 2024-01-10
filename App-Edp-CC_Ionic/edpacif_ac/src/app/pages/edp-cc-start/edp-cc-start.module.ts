import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { EdpCcStartPageRoutingModule } from './edp-cc-start-routing.module';

import { EdpCcStartPage } from './edp-cc-start.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    EdpCcStartPageRoutingModule
  ],
  declarations: [EdpCcStartPage]
})
export class EdpCcStartPageModule {}
