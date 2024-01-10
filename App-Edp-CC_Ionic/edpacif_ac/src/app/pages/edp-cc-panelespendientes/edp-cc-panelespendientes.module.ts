import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { EdpCcPanelespendientesPageRoutingModule } from './edp-cc-panelespendientes-routing.module';

import { EdpCcPanelespendientesPage } from './edp-cc-panelespendientes.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    EdpCcPanelespendientesPageRoutingModule
  ],
  declarations: [EdpCcPanelespendientesPage]
})
export class EdpCcPanelespendientesPageModule {}
