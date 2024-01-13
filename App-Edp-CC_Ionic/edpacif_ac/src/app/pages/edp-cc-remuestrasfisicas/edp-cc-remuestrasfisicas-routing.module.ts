import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { EdpCcRemuestrasfisicasPage } from './edp-cc-remuestrasfisicas.page';

const routes: Routes = [
  {
    path: '',
    component: EdpCcRemuestrasfisicasPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class EdpCcRemuestrasfisicasPageRoutingModule {}
