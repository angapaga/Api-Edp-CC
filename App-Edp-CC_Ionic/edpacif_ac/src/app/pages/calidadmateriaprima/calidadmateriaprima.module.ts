import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { CalidadmateriaprimaPageRoutingModule } from './calidadmateriaprima-routing.module';

import { CalidadmateriaprimaPage } from './calidadmateriaprima.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    CalidadmateriaprimaPageRoutingModule
  ],
  declarations: [CalidadmateriaprimaPage]
})
export class CalidadmateriaprimaPageModule {}
