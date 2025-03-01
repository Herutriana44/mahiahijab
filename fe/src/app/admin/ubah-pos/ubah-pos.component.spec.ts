import { ComponentFixture, TestBed } from '@angular/core/testing';

import { UbahPosComponent } from './ubah-pos.component';

describe('UbahPosComponent', () => {
  let component: UbahPosComponent;
  let fixture: ComponentFixture<UbahPosComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [UbahPosComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(UbahPosComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
