import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { EdpCcRemuestrasfisicasPageRoutingModule } from './edp-cc-remuestrasfisicas-routing.module';

import { EdpCcRemuestrasfisicasPage } from './edp-cc-remuestrasfisicas.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    EdpCcRemuestrasfisicasPageRoutingModule
  ],
  declarations: [EdpCcRemuestrasfisicasPage]
})
export class EdpCcRemuestrasfisicasPageModule {}
