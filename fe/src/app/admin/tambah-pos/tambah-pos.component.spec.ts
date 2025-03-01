import { ComponentFixture, TestBed } from '@angular/core/testing';

import { TambahPosComponent } from './tambah-pos.component';

describe('TambahPosComponent', () => {
  let component: TambahPosComponent;
  let fixture: ComponentFixture<TambahPosComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [TambahPosComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(TambahPosComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
