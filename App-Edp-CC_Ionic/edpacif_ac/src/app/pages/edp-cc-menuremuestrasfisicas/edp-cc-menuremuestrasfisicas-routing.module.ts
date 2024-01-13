import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { EdpCcMenuremuestrasfisicasPage } from './edp-cc-menuremuestrasfisicas.page';

const routes: Routes = [
  {
    path: '',
    component: EdpCcMenuremuestrasfisicasPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class EdpCcMenuremuestrasfisicasPageRoutingModule {}
