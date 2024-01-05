import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { PanelsaborPage } from './panelsabor.page';

const routes: Routes = [
  {
    path: '',
    component: PanelsaborPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class PanelsaborPageRoutingModule {}
