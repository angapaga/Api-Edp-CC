import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { EdpCcMenuremuestrasfisicasPageRoutingModule } from './edp-cc-menuremuestrasfisicas-routing.module';

import { EdpCcMenuremuestrasfisicasPage } from './edp-cc-menuremuestrasfisicas.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    EdpCcMenuremuestrasfisicasPageRoutingModule
  ],
  declarations: [EdpCcMenuremuestrasfisicasPage]
})
export class EdpCcMenuremuestrasfisicasPageModule {}
