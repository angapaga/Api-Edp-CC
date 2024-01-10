import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { EdpCcCalidadmateriaprimaPageRoutingModule } from './edp-cc-calidadmateriaprima-routing.module';

import { EdpCcCalidadmateriaprimaPage } from './edp-cc-calidadmateriaprima.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    EdpCcCalidadmateriaprimaPageRoutingModule
  ],
  declarations: [EdpCcCalidadmateriaprimaPage]
})
export class EdpCcCalidadmateriaprimaPageModule {}
