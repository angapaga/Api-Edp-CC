import { ComponentFixture, TestBed } from '@angular/core/testing';
import { PanelsaborPage } from './panelsabor.page';

describe('PanelsaborPage', () => {
  let component: PanelsaborPage;
  let fixture: ComponentFixture<PanelsaborPage>;

  beforeEach(async(() => {
    fixture = TestBed.createComponent(PanelsaborPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  }));

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
