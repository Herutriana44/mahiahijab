import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AdminUbahPosComponent } from './ubah-pos.component';

describe('UbahPosComponent', () => {
  let component: AdminUbahPosComponent;
  let fixture: ComponentFixture<AdminUbahPosComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [AdminUbahPosComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(AdminUbahPosComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
