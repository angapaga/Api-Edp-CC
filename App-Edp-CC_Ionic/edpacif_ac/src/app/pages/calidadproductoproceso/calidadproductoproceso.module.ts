import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { CalidadproductoprocesoPageRoutingModule } from './calidadproductoproceso-routing.module';

import { CalidadproductoprocesoPage } from './calidadproductoproceso.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    CalidadproductoprocesoPageRoutingModule
  ],
  declarations: [CalidadproductoprocesoPage]
})
export class CalidadproductoprocesoPageModule {}
