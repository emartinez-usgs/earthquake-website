<?php
// Author: Lisa Wald
// Contact: Gavin Hayes, ghayes@usgs.gov
if (!isset($TEMPLATE)) {
  $TITLE = 'Finite Faults';
  $NAVIGATION = true;
  $HEAD = '
    <link rel="stylesheet" href="/lib/earthquake-list-widget-1.0.0/earthquake-list-widget.css"/>
  ';
  $FOOT = '
    <script src="/lib/earthquake-list-widget-1.0.0/earthquake-list-widget.js"></script>
    <script src="index.js"></script>
  ';
  include 'template.inc.php';
}
?>

<div class="row right-to-left" >

  <div class="column two-of-five">
      <h3>Finite Faults, Past 1 Year</h3>

      <div class="recent-products" style="overflow:scroll; height:400px; background:#f4f4f4;">
        <noscript class="error alert">
          Javascript is used to load event data. If you can not enable Javascript,
          you can <a href="/fdsnws/event/1/query.geojson?producttype=finite-fault&starttime=-1+year">view
          the raw data here</a>.
        </noscript>
      </div>

        <h3>View Map and List of Finite Fault Events</h3>
        <ul>
          <li>
            <a href="/earthquakes/map/#<?php

                $id = "" . time();
                $params = array(
                  "feed" => $id,
                  "search" => array(
                    "id" => $id,
                    "name" => "Finite Fault, Past Year",
                    "isSearch" => true,
                    "params" => array(
                      "starttime" => "-1 year",
                      "producttype" => "finite-fault"
                    )
                  ),
                  "basemap" => "terrain",
                  "listFormat" => "shakemap",
                  "mapposition" => array(
                    array(-85, 0),
                    array(85, 360)
                  ),
                  "timeZone" => "utc",
                  "viewModes" => array(
                    "map" => true,
                    "list" => true
                  )
                );
                echo rawurlencode(json_encode($params));

            ?>">Past Year</a>
          </li>
      </ul>

      <ul class="no-style linklist">

        <li>
          <a href="/earthquakes/search/#<?php

              $id = "" . time();
              $params = array(
                "feed" => $id,
                "search" => array(
                  "id" => $id,
                  "name" => "Finite Fault",
                  "isSearch" => true,
                  "params" => array(
                    "producttype" => "finite-fault"
                  )
                ),
                "basemap" => "terrain",
                "timeZone" => "utc",
                "viewModes" => array(
                  "map" => true,
                  "list" => true
                )
              );
              echo rawurlencode(json_encode($params));

          ?>">
            <h4>Search Finite Fault Archives</h4>
            <img src="/data/shakemap/images/search-2x.gif" alt="" width="75"/>
          </a>
          <p>Search for events that include Finite Faults. The Search form link from here is already configured to return only events with Finite Fault products. You enter additional search parameters. The default time window is the past 30 days.</p>

          <h4>Download Formats</h4>
          <p>
            For each model, a series of downloadable files are included that describe:
            <ul>
              <li>
                the finite fault itself (in both a static format familiar to users of rapid NEIC fault models, and in the new SRCMOD Finite Source Parameter (FSP) format, Mai et al., 2016);
              </li>
              <li>
                an ASCII source time function for the event;
              </li>
              <li>
                the global Centroid Moment Tensor (gCMT) CMTSOLUTION for each sub-event (http ://globalcmt.org);
              </li>
              <li>
                input files for the Coulomb3 software package (Toda et al., 2005, 2011 and
              </li>
              <li>
                three-components of predicted ground deformation, computed using the Okada(1992) formulation on a grid surrounding the sur-face expression of the model. For more details, see Hayes (2017)
              </li>
            </ul>
          </p>
        </li>
      </ul>

  </div>

  <div class="column three-of-five">

    <h2>Introduction</h2>
    <p>When earthquakes occur, they involve slip over a fault area rather than at a point source. How much the fault slips, and over how large an area, are both related to the size of the event – in fact, seismic moment is the product of slip, fault area, and shear modulus, a variable related to the geophysical properties of rock in the earthquake source region. Slip magnitude and extent can be modeled via a “finite fault inversion”, which uses recordings of the earthquake to reconstruct its slip history. The resulting “finite fault models” can be static (if using non-continuous geodetic data, like InSAR, campaign or low sample rate GPS data) or kinematic (using seismic, high-rate GPS or tsunami data). Since the shaking caused by an earthquake – and thus the impact it has on people and infrastructure – are related to the spatial extent of slip on the fault, constraining the slip history of a recent earthquake is a very important step to earthquake response at the NEIC, to improve our real time estimates of earthquake shaking (<a href="shakemap/">ShakeMap</a>) and related fatalities and loses (<a href="pager/">PAGER</a>).
    </p>

    <h2>Data Process and Inversion</h2>
    <p>
      Finite fault models generated by the USGS NEIC generally employ a kinematic finite fault inversion approach based on the method of Ji et al. (2002), which carries out the inversion in the wavelet domain. The procedure inverts both body-wave (P and SH, band-pass filtered between 1 and 200 s) and surface wave (Rayleigh and Love, band-pass filtered between 200 and 500 s) data on a fault surface defined a priori, typically aligned with estimates from CMT (either USGS W-phase or gCMT) solutions.
    </p>
    <p>
      Both nodal planes of the initial CMT solution are tested to account for the uncertainty over which plane describes the causative fault. We may further divide a favored plane into multiple fault segments if required by the data or suggested by other information. Similarly, strike and dip of the inverted fault plane (or planes) are systematically varied from the initial geometry to test model sensitivity to these assumptions.
    </p>
    <p>
      Data are chosen based on producing an azimuthally balanced data set, while avoiding the inclusion of data with small signal-to-noise ratios. Rupture velocity can be fixed or allowed to vary; to account for unknown rupture characteristics, variable velocities are generally tested, as are a broad distribution of fixed velocities, before settling on a final model where rupture velocity is allowed to vary about a favored fixed value.
    </p>
    <p>
      Initial fault length is estimated from empirical relations between duration and moment (Dahlen and Tromp, 1998), scaled to length assuming a rupture velocity of 2.5 km/s, and doubled to account for uncertainty in rupture direction (i.e., centered bilaterally on the hypocenter). Green's functions are generated using a velocity model based on PREM and Crust2.0 (Bassin et al., 2000), and the frequency-wavenumber algorithm of Zhu & Rivera (2001).
    </p>
    <p>
      Fault planes are divided into a series of sub-faults along the strike and dip directions, and the inversion uses a simulated annealing approach to simultaneously solve for the slip amplitude, slip direction, rise-time and rupture initiation time of each sub-fault, where sub-fault source time functions are modeled with an asymmetric cosine function (Ji et al., 2002, 2003).
    </p>
    <p>
      The model is referenced spatially to the USGS NEIC hypocenter, at least initially; as with other key parameters, location is varied when other information (e.g., regional network solutions and/or published studies) indicates a necessary relocation. For more details on this approach and our results for past earthquakes, see Hayes (2017).
    </p>

    <h2>References</h2>
    <ul class="referencelist">
      <li>
        Bassin, C., Laske, G. and Masters, G., The Current Limits of Resolution for Surface Wave Tomography in North America, EOS Trans AGU, 81, F897, 2000.
      </li>
      <li>
        Dahlen, F.A., Tromp, J., 1998. Theoretical Global Seismology. Princeton University Press, Princeton, NJ.
      </li>
      <li>
        Hayes, G.P., 2017. The finite, kinematic rupture properties of great-sized earthquakes since 1990. Earth Planet. Sci. Lett. 468, doi:10.1016/j.epsl.2017.04.003.
      </li>
      <li>
        Ji, C., D.J. Wald, and D.V. Helmberger, Source description of the 1999 Hector Mine, California earthquake; Part I: Wavelet domain inversion theory and resolution analysis, Bull. Seism. Soc. Am., Vol 92, No. 4. pp. 1192-1207, 2002.
      </li>
      <li>
        Ji, C., D. V. Helmberger, D. J. Wald, and K. F. Ma (2003), Slip history and dynamic implications of the 1999 Chi-Chi, Taiwan, earthquake, J Geophys Res-Sol Ea, 108(B9).
      </li>
      <li>
        Shao, G. F., X. Y. Li, C. Ji, and T. Maeda (2011), Focal mechanism and slip history of the 2011 M-w 9.1 off the Pacific coast of Tohoku Earthquake, constrained with teleseismic body and surface waves, Earth Planets Space, 63(7), 559-564.
      </li>
      <li>
        Zhu, L., and L. A. Rivera (2001). Computation of dynamic and static displacement from a point source in multi-layered media, Geophys. J. Int. 148, no. 3, 619–627.
      </li>
    </ul>

  </div>
</div>
